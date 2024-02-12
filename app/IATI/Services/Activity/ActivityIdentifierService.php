<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Repositories\Activity\ActivityRepository;
use Kris\LaravelFormBuilder\Form;

/**
 * Class ActivityIdentifierService.
 */
class ActivityIdentifierService
{
    /**
     * @var ActivityRepository
     */
    protected activityRepository $activityRepository;

    /**
     * @var BaseFormCreator
     */
    protected BaseFormCreator $baseFormCreator;

    /**
     * ActivityIdentifierService constructor.
     *
     * @param ActivityRepository $activityRepository
     * @param BaseFormCreator    $baseFormCreator
     */
    public function __construct(activityRepository $activityRepository, BaseFormCreator $baseFormCreator)
    {
        $this->activityRepository = $activityRepository;
        $this->baseFormCreator = $baseFormCreator;
    }

    /**
     * Returns activity identifier data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getActivityIdentifierData(int $activity_id): ?array
    {
        $activity = $this->activityRepository->find($activity_id);

        return $activity->iati_identifier;
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
     * Updates activity identifier.
     *
     * @param $id
     * @param $activityIdentifier
     *
     * @return bool
     */
    public function update($id, $activityIdentifier): bool
    {
        $hasEverBeenPublished = $this->activityRepository->find($id, ['has_ever_been_published'])['has_ever_been_published'];

        if (!$hasEverBeenPublished) {
            $activityIdentifier['present_organization_identifier'] = auth()->user()->organization->identifier;

            return $this->activityRepository->update($id, ['iati_identifier' => $activityIdentifier]);
        }

        return false;
    }

    /**
     * Generates budget form.
     *
     * @param $id
     *
     * @return Form
     * @throws \JsonException
     */
    public function formGenerator($id): Form
    {
        $element = getElementSchema('iati_identifier');
        $model['activity_identifier'] = $this->getActivityIdentifierData($id);
        $this->baseFormCreator->url = route('admin.activity.identifier.update', [$id]);
        $activity = $this->activityRepository->find($id, ['has_ever_been_published']);
        $showCancelOrSaveButton = true;

        if ($activity['has_ever_been_published']) {
            $element['attributes']['activity_identifier']['read_only'] = true;
            $showCancelOrSaveButton = false;
        }

        return $this->baseFormCreator->editForm($model['activity_identifier'], $element, 'PUT', '/activity/' . $id, $showCancelOrSaveButton);
    }
}
