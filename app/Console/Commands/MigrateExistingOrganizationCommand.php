<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Exceptions\PublishException;
use Carbon\Carbon;

/**
 * Class MigrateExistingOrganizationCommand.
 */
class MigrateExistingOrganizationCommand extends MigrateOrganizationCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:existing-organization';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrates the organization present on AidStream who have already created an account on IATI Publisher.';

    /**
     * Execute the console command.
     *
     * @return void
     *
     * @throws \Throwable
     */
    public function handle(): void
    {
        try {
            $aidstreamOrganizationIdString = $this->askValid(
                'Please enter the existing organization ids which you want to migrate separated by comma (Compulsory)',
                'aidstreamOrganizationIdString',
                ['required']
            );

            $aidstreamOrganizationIds = explode(',', $aidstreamOrganizationIdString);

            // Convert all the values to integer.
            foreach ($aidstreamOrganizationIds as $key => $aidstreamOrganizationId) {
                $aidstreamOrganizationIds[$key] = (int) $aidstreamOrganizationId;
            }

            foreach ($aidstreamOrganizationIds as $aidstreamOrganizationId) {
                try {
                    $this->logInfo('Started organization migration for organization id: ' . $aidstreamOrganizationId);
                    $this->databaseManager->beginTransaction();
                    $aidStreamOrganization = $this->db::connection('aidstream')->table('organizations')->where(
                        'id',
                        $aidstreamOrganizationId
                    )->first();

                    if (!$aidStreamOrganization) {
                        $message = 'AidStream organization not found with id: ' . $aidstreamOrganizationId;
                        $this->setGeneralError($message)->setDetailedError(
                            $message,
                            $aidstreamOrganizationId,
                            'organization_data',
                            $aidstreamOrganizationId
                        );
                        $this->error($message);
                        $timestamp = Carbon::now()->format('y-m-d-H-i-s');
                        awsUploadFile(
                            "Migration/Migration-errors-{$aidstreamOrganizationId}-{$timestamp}.json",
                            json_encode($this->errors, JSON_THROW_ON_ERROR)
                        );
                        $this->clearErrors();

                        throw new \RuntimeException(
                            $message
                        );
                    }

                    $aidStreamOrganizationSetting = $this->db::connection('aidstream')->table('settings')->where(
                        'organization_id',
                        $aidstreamOrganizationId
                    )->first();

                    $publisherId = $aidStreamOrganization->user_identifier;

                    if ($aidStreamOrganizationSetting) {
                        $publisherId = $this->getSettingsPublisherId(
                            $aidStreamOrganizationSetting,
                            $aidStreamOrganization->user_identifier
                        );
                    }

                    $iatiOrganization = $this->organizationService->getOrganizationByPublisherId(
                        strtolower($publisherId)
                    );

                    if (!$iatiOrganization) {
                        $message = "Organization with publisher id {$publisherId} does not exist. Please run the command migrate:organization.";
                        $this->setGeneralError($message)->setDetailedError(
                            $message,
                            $aidstreamOrganizationId,
                            'organization',
                            $aidstreamOrganizationId
                        );
                        $timestamp = Carbon::now()->format('y-m-d-H-i-s');
                        awsUploadFile(
                            "Migration/Migration-errors-{$aidstreamOrganizationId}-{$timestamp}.json",
                            json_encode($this->errors, JSON_THROW_ON_ERROR)
                        );
                        $this->clearErrors();

                        throw new \RuntimeException(
                            $message
                        );
                    }

                    $this->logInfo(
                        "Started organization dates update for organization id: {$aidstreamOrganizationId}."
                    );
                    $iatiOrganization = $this->updateOnlyDates($aidStreamOrganization, $iatiOrganization);
                    $this->logInfo(
                        "Completed organization dates update for organization id: {$aidstreamOrganizationId}."
                    );

                    $this->setting = null;
                    $this->logInfo(
                        "Started checking if settings need to be created/updated for organization id: {$aidstreamOrganizationId}."
                    );
                    $this->setting = $this->updateSettingsIfNeeded($iatiOrganization, $aidStreamOrganizationSetting);
                    $this->logInfo("Completed settings migration for organization id: {$aidstreamOrganizationId}.");

                    $aidstreamUsers = $this->db::connection('aidstream')->table('users')->where(
                        'org_id',
                        $aidstreamOrganizationId
                    )->get();

                    if (count($aidstreamUsers)) {
                        $this->logInfo(
                            "Started checking if users need to be migrated for organization id: {$aidstreamOrganizationId}."
                        );
                        $this->migrateUsersIfNeeded($iatiOrganization, $aidstreamUsers, $aidStreamOrganization);
                        $this->logInfo("Completed users migration for organization id: {$aidstreamOrganizationId}.");
                    }

                    $aidstreamActivities = $this->db::connection('aidstream')->table('activity_data')->where(
                        'organization_id',
                        $aidstreamOrganizationId
                    )->get();

                    $activityPublished = null;

                    if (count($aidstreamActivities)) {
                        $this->logInfo(
                            "Started checking if activities need to be migrated for organization id: {$aidstreamOrganizationId}."
                        );
                        $activityPublished = $this->migrateActivitiesAndOthersIfNeeded(
                            $iatiOrganization,
                            $aidstreamActivities,
                            $aidStreamOrganization,
                            $aidStreamOrganizationSetting
                        );
                        $this->logInfo(
                            "Completed activities migration for organization id: {$aidstreamOrganizationId}."
                        );
                    }

                    $this->publishFilesToRegistry(
                        null,
                        $iatiOrganization,
                        $aidStreamOrganization,
                        $activityPublished,
                        $this->setting,
                        false
                    );

                    $this->disableAidstreamOrg($aidstreamOrganizationId);
                    $this->auditService->setAuditableId($iatiOrganization->id)->auditMigrationEvent(
                        $iatiOrganization,
                        'migrated-organization'
                    );

                    $this->databaseManager->commit();

                    if ($this->hasErrors()) {
                        $timestamp = Carbon::now()->format('y-m-d-H-i-s');
                        awsUploadFile("Migration/Migration-errors-{$aidstreamOrganizationId}-{$timestamp}.json", json_encode($this->errors));
                    }

                    $this->clearErrors();
                } catch (PublishException $publishException) {
                    logger()->channel('migration')->error($publishException->getMessage());
                    $this->error($publishException->getMessage());

                    $iatiOrganization = $this->organizationService->getOrganizationData(
                        $publishException->getIatiOrganizationId()
                    );
                    $iatiOrganization->updateQuietly([
                        'org_status' => 'disabled',
                    ]);
                    $iatiOrganization->users()->update([
                        'status' => false,
                    ]);
                    $this->databaseManager->commit();
                    continue;
                } catch (\Exception $exception) {
                    $this->databaseManager->rollBack();
                    logger()->channel('migration')->error($exception);
                    $this->error($exception->getMessage());
                    continue;
                }
            }
        } catch (\Exception $exception) {
            logger()->channel('migration')->error($exception);
            $this->error($exception->getMessage());
        }
    }
}
