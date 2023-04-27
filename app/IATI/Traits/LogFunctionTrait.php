<?php

declare(strict_types=1);

namespace App\IATI\Traits;

use App\Exceptions\PublishException;
use Carbon\Carbon;

/*
 * Class LogFunctionTrait
 */
trait LogFunctionTrait
{
    /**
     * Log Activity Not Published Because Of Token Verification.
     *
     * @throws PublishException
     */
    private function logActivityNotPublishedBecauseOfTokenVerification($aidStreamOrganization, $iatiOrganization, $activityPublished)
    {
        $message = "Activity file: {$activityPublished->filename} of Organization: {$aidStreamOrganization?->name} not published because 'token_verification' is not valid.";
        $this->setGeneralError($message)->setDetailedError(
            $message,
            $aidStreamOrganization->id,
            'activity_published',
            $activityPublished->id,
            $iatiOrganization->id,
        );
        $this->logInfo($message);

        throw new PublishException($iatiOrganization->id, $message);
    }

    /**
     * Log Activity Not Published Because Of Publisher Verification.
     *
     * @throws PublishException
     */
    private function logActivityNotPublishedBecauseOfPublisherVerification($aidStreamOrganization, $iatiOrganization, $activityPublished)
    {
        $message = "Activity file: {$activityPublished->filename} of Organization: {$aidStreamOrganization?->name} not published because 'publisher_verification' is not valid.";
        $this->setGeneralError($message)->setDetailedError(
            $message,
            $aidStreamOrganization->id,
            'activity_published',
            $activityPublished->id,
            $iatiOrganization->id,
        );
        $this->logInfo($message);

        throw new PublishException($iatiOrganization->id, $message);
    }

    /**
     * Log Activity Not Published Because Organization Setting Not Valid.
     *
     * @throws PublishException
     */
    private function logActivityNotPublishedBecauseOrganizationSettingNotValid($aidStreamOrganization, $iatiOrganization, $activityPublished)
    {
        $message = "Activity file: {$activityPublished->filename} of Organization : {$aidStreamOrganization?->name} not published because 'organization setting' is not valid. ";
        $this->setGeneralError($message)->setDetailedError(
            $message,
            $aidStreamOrganization->id,
            'activity_published',
            $activityPublished->id,
            $iatiOrganization->id,
        );
        $this->logInfo($message);

        throw new PublishException($iatiOrganization->id, $message);
    }

    /**
     * Log Activity Not Published Because Published To RegistryIsFalse.
     *
     * @param $aidStreamOrganization
     * @param $iatiOrganization
     * @param $activityPublished
     *
     * @return void
     */
    private function logActivityNotPublishedBecausePublishedToRegistryIsFalse($aidStreamOrganization, $iatiOrganization, $activityPublished): void
    {
        $message = "Activity file: {$activityPublished->filename} of Organization: {$aidStreamOrganization?->name} not published as 'published to registry' is false.";
        $this->setGeneralError($message)->setDetailedError(
            $message,
            $aidStreamOrganization->id,
            'activity_published',
            $activityPublished->id,
            $iatiOrganization->id,
            '',
            'Activity file > publishing'
        );
        $this->logInfo($message);
    }

    /**
     * Log Organization Not Published Because Token Verification.
     *
     * @param $aidStreamOrganization
     * @param $iatiOrganization
     * @param $organizationPublished
     *
     * @return mixed
     *
     * @throws PublishException
     */
    private function logOrganizationNotPublishedBecauseTokenVerification($aidStreamOrganization, $iatiOrganization, $organizationPublished): mixed
    {
        $message = "Organization file: {$organizationPublished->filename} not published because 'token_verification' is not valid.'";
        $this->setGeneralError($message)->setDetailedError(
            $message,
            $aidStreamOrganization->id,
            'organization_published',
            $organizationPublished->id,
        );
        $this->logInfo($message);
        $timestamp = Carbon::now()->format('y-m-d-H-i-s');
        awsUploadFile("Migration/Migration-errors-{$aidStreamOrganization->id}-{$timestamp}.json", json_encode($this->errors));

        throw new PublishException($iatiOrganization->id, $message);
    }

    /**
     * Log Organization Not Published Because Publisher Verification.
     *
     * @param $aidStreamOrganization
     * @param $iatiOrganization
     * @param $organizationPublished
     *
     * @return mixed
     *
     * @throws PublishException
     */
    private function logOrganizationNotPublishedBecausePublisherVerification($aidStreamOrganization, $iatiOrganization, $organizationPublished): mixed
    {
        $message = "Organization file: {$organizationPublished->filename} not published because 'publisher_verification' is not valid.'";
        $this->setGeneralError($message)->setDetailedError(
            $message,
            $aidStreamOrganization->id,
            'organization_published',
            $organizationPublished->id,
            $iatiOrganization->id
        );
        $this->logInfo($message);
        $timestamp = Carbon::now()->format('y-m-d-H-i-s');
        awsUploadFile("Migration/Migration-errors-{$aidStreamOrganization->id}-{$timestamp}.json", json_encode($this->errors));

        throw new PublishException($iatiOrganization->id, $message);
    }

    /**
     * Log Organization Not Published Because Organization Setting Is Not Valid.
     *
     * @throws PublishException
     */
    private function logOrganizationNotPublishedBecauseOrganizationSettingIsNotValid($aidStreamOrganization, $iatiOrganization, $organizationPublished, $setting)
    {
        $message = "Organization file: {$organizationPublished->filename} not published because 'organization setting' is not valid.'";
        $this->setGeneralError($message)->setDetailedError(
            $message,
            $aidStreamOrganization->id,
            'settings',
            $setting->id,
            $iatiOrganization->id
        );
        $this->logInfo($message);

        throw new PublishException($iatiOrganization->id, $message);
    }

    /**
     * Log Organization Not Published Because Published To Registry Is False.
     *
     * @param $aidStreamOrganization
     * @param $iatiOrganization
     * @param $organizationPublished
     *
     * @return void
     */
    private function logOrganizationNotPublishedBecausePublishedToRegistryIsFalse($aidStreamOrganization, $iatiOrganization, $organizationPublished): void
    {
        $message = "Organization file: {$organizationPublished->filename} not published as 'published to registry' is false.";
        $this->setGeneralError($message)->setDetailedError(
            $message,
            $aidStreamOrganization->id,
            'organization_published',
            $organizationPublished->id,
            $iatiOrganization->id,
            '',
            'Organization file > publishing'
        );
        $this->logInfo($message);
    }
}
