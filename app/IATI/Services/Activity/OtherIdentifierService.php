<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\MultilevelSubElementFormCreator;
use App\IATI\Repositories\Activity\ActivityRepository;
use Kris\LaravelFormBuilder\Form;

/**
 * Class OtherIdentifierService.
 */
class OtherIdentifierService
{
    /**
     * @var ActivityRepository
     */
    protected ActivityRepository $activityRepository;

    /**
     * @var MultilevelSubElementFormCreator
     */
    protected MultilevelSubElementFormCreator $multilevelSubElementFormCreator;

    /**
     * OtherIdentifierService constructor.
     *
     * @param ActivityRepository $activityRepository
     * @param MultilevelSubElementFormCreator $multilevelSubElementFormCreator
     */
    public function __construct(ActivityRepository $activityRepository, MultilevelSubElementFormCreator $multilevelSubElementFormCreator)
    {
        $this->activityRepository = $activityRepository;
        $this->multilevelSubElementFormCreator = $multilevelSubElementFormCreator;
    }

    /**
     * Returns other identifier data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getOtherIdentifierData(int $activity_id): ?array
    {
        return $this->activityRepository->find($activity_id)->other_identifier;
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
     * @param $activityIdentifier
     * @param $activity
     *
     * @return bool
     */
    public function update($activityIdentifier, $activity): bool
    {
        return $this->activityRepository->update($activity->id, ['other_identifier' => $this->sanitizeOtherIdentifierData($activityIdentifier)]);
    }

    /**
     * Generates other identifier form.
     *
     * @param id
     *
     * @return Form
     */
    public function formGenerator($id): Form
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $model = $this->getOtherIdentifierData($id) ?: [];
        $this->multilevelSubElementFormCreator->url = route('admin.activity.other-identifier.update', [$id]);

        return $this->multilevelSubElementFormCreator->editForm($model, $element['other_identifier'], 'PUT', '/activity/' . $id);
    }

    /**
     * Sanitizes other identifier data.
     *
     * @param $activityIdentifier
     *
     * @return array
     */
    public function sanitizeOtherIdentifierData($activityIdentifier): array
    {
        $activityIdentifier['owner_org'] = array_values($activityIdentifier['owner_org']);

        foreach ($activityIdentifier['owner_org'] as $owner_index => $owner_value) {
            $activityIdentifier['owner_org'][$owner_index]['narrative'] = array_values($owner_value['narrative']);
        }

        return $activityIdentifier;
    }
}
