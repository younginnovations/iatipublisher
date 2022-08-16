<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Repositories\Activity\ParticipatingOrganizationRepository;
use Illuminate\Database\Eloquent\Model;
use Kris\LaravelFormBuilder\Form;

/**
 * Class participatingOrganization
 *Service.
 */
class ParticipatingOrganizationService
{
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
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $model['participating_org'] = $this->getParticipatingOrganizationData($id) ?: [];
        $this->parentCollectionFormCreator->url = route('admin.activity.participating-org.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element['participating_org'], 'PUT', '/activity/' . $id);
    }
}
