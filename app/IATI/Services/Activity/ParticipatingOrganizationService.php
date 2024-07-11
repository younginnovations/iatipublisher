<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\ActivityRepository;
use App\IATI\Traits\XmlBaseElement;
use Illuminate\Support\Arr;
use Kris\LaravelFormBuilder\Form;

/**
 * Class ParticipatingOrganizationService.
 */
class ParticipatingOrganizationService
{
    use XmlBaseElement;

    /**
     * @var ActivityRepository
     */
    protected ActivityRepository $activityRepository;

    /**
     * @var ParentCollectionFormCreator
     */
    protected ParentCollectionFormCreator $parentCollectionFormCreator;

    /**
     * ParticipatingOrganizationService constructor.
     *
     * @param ActivityRepository $activityRepository
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     */
    public function __construct(ActivityRepository $activityRepository, ParentCollectionFormCreator $parentCollectionFormCreator)
    {
        $this->activityRepository = $activityRepository;
        $this->parentCollectionFormCreator = $parentCollectionFormCreator;
    }

    /**
     * Returns participating organization data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getParticipatingOrganizationData(int $activity_id): ?array
    {
        return $this->activityRepository->find($activity_id)->participating_org;
    }

    /**
     * Returns activity object.
     *
     * @param $id
     *
     * @return object
     */
    public function getActivityData($id): object
    {
        return $this->activityRepository->find($id);
    }

    /**
     * Updates activity participating organization.
     *
     * @param $id
     * @param $participatingOrganization
     *
     * @return bool
     */
    public function update($id, $participatingOrganization): bool
    {
        $participatingOrganization = $this->sanitizeParticipatingOrgData($participatingOrganization);

        $activity = $this->activityRepository->find($id);
        $deprecationStatusMap = $activity->deprecation_status_map;

        $deprecationStatusMap['participating_org'] = doesParticipatingOrgHaveDeprecatedCode($participatingOrganization);

        return $this->activityRepository->update($id, [
            'participating_org'      => $participatingOrganization,
            'deprecation_status_map' => $deprecationStatusMap,
        ]);
    }

    /**
     * Generates participating organization form.
     *
     * @param $id
     *
     * @return Form
     * @throws \JsonException
     */
    public function formGenerator($id, $activityDefaultFieldValues, $deprecationStatusMap = []): Form
    {
        $element = getElementSchema('participating_org');
        $model['participating_org'] = $this->getParticipatingOrganizationData($id) ?: [];
        $this->parentCollectionFormCreator->url = route('admin.activity.participating-org.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element, 'PUT', '/activity/' . $id, $activityDefaultFieldValues, deprecationStatusMap: $deprecationStatusMap);
    }

    /**
     * Returns data in required xml array format.
     *
     * @param Activity $activity
     *
     * @return array
     */
    public function getXmlData(Activity $activity): array
    {
        $activityData = [];
        $participatingOrganizations = (array) $activity->participating_org;

        if (count($participatingOrganizations)) {
            foreach ($participatingOrganizations as $participatingOrganization) {
                $activityData[] = [
                    '@attributes' => [
                        'ref'         => Arr::get($participatingOrganization, 'ref', null),
                        'type'        => Arr::get($participatingOrganization, 'type', null),
                        'role'        => Arr::get($participatingOrganization, 'organization_role', null),
                        'activity-id' => Arr::get($participatingOrganization, 'identifier', null),
                        'crs-channel-code' => Arr::get($participatingOrganization, 'crs_channel_code', null),
                    ],
                    'narrative'   => $this->buildNarrative(Arr::get($participatingOrganization, 'narrative', [])),
                ];
            }
        }

        return $activityData;
    }

    /**
     * Sanitizes participating org data.
     *
     * @param $participatingOrganization
     *
     * @return array
     */
    public function sanitizeParticipatingOrgData($participatingOrganization): array
    {
        foreach ($participatingOrganization['participating_org'] as $key => $participating_org) {
            $participatingOrganization['participating_org'][$key]['narrative'] = array_values($participating_org['narrative']);
        }

        return array_values($participatingOrganization['participating_org']);
    }
}
