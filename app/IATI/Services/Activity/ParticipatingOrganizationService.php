<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\ParticipatingOrganizationRepository;
use App\IATI\Traits\XmlBaseElement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Kris\LaravelFormBuilder\Form;

/**
 * Class participatingOrganization
 *Service.
 */
class ParticipatingOrganizationService
{
    use XmlBaseElement;

    /**
     * @var ParticipatingOrganizationRepository
     */
    protected ParticipatingOrganizationRepository $participatingOrganizationRepository;

    /**
     * @var ParentCollectionFormCreator
     */
    protected ParentCollectionFormCreator $parentCollectionFormCreator;

    /**
     * ParticipatingOrganizationService constructor.
     *
     * @param ParticipatingOrganizationRepository $participatingOrganizationRepository
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     */
    public function __construct(ParticipatingOrganizationRepository $participatingOrganizationRepository, ParentCollectionFormCreator $parentCollectionFormCreator)
    {
        $this->participatingOrganizationRepo = $participatingOrganizationRepository;
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
        return $this->participatingOrganizationRepo->getParticipatingOrganizationData($activity_id);
    }

    /**
     * Returns activity object.
     *
     * @param $id
     *
     * @return Model
     */
    public function getActivityData($id): Model
    {
        return $this->participatingOrganizationRepo->getActivityData($id);
    }

    /**
     * Updates activity participating organization.
     *
     * @param $participatingOrganization
     * @param $activity
     *
     * @return bool
     */
    public function update($participatingOrganization, $activity): bool
    {
        return $this->participatingOrganizationRepo->update($participatingOrganization, $activity);
    }

    /**
     * Generates participating organization form.
     *
     * @param id
     *
     * @return Form
     */
    public function formGenerator($id): Form
    {
        $element = getElementSchema('participating_org');
        $model['participating_org'] = $this->getParticipatingOrganizationData($id) ?: [];
        $this->parentCollectionFormCreator->url = route('admin.activities.participating-org.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element, 'PUT', '/activities/' . $id);
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
}
