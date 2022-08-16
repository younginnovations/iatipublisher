<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Repositories\Activity\ActivityIdentifierRepository;
use Illuminate\Database\Eloquent\Model;
use Kris\LaravelFormBuilder\Form;

/**
 * Class ActivityIdentifierService.
 */
class ActivityIdentifierService
{
    /**
     * @var ActivityIdentifierRepository
     */
    protected ActivityIdentifierRepository $activityIdentifierRepository;

    /**
     * @var BaseFormCreator
     */
    protected BaseFormCreator $baseFormCreator;

    /**
     * ActivityIdentifierService constructor.
     *
     * @param ActivityIdentifierRepository $activityIdentifierRepository
     * @param BaseFormCreator $baseFormCreator
     */
    public function __construct(ActivityIdentifierRepository $activityIdentifierRepository, BaseFormCreator $baseFormCreator)
    {
        $this->activityIdentifierRepository = $activityIdentifierRepository;
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
        return $this->activityIdentifierRepository->getActivityIdentifierData($activity_id);
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
        return $this->activityIdentifierRepository->getActivityData($id);
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
        return $this->activityIdentifierRepository->update($activityIdentifier, $activity);
    }

    /**
     * Generates budget form.
     *
     * @param id
     *
     * @return Form
     */
    public function formGenerator($id): Form
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $model['activity_identifier'] = $this->getActivityIdentifierData($id);
        $this->baseFormCreator->url = route('admin.activity.identifier.update', [$id]);

        return $this->baseFormCreator->editForm($model['activity_identifier'], $element['iati_identifier'], 'PUT', '/activities/' . $id);
    }
}
