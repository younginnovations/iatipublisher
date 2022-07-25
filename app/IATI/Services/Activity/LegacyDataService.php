<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Repositories\Activity\LegacyDataRepository;
use Illuminate\Database\Eloquent\Model;
use Kris\LaravelFormBuilder\Form;

/**
 * Class LegacyDataService.
 */
class LegacyDataService
{
    /**
     * @var LegacyDataRepository
     */
    protected LegacyDataRepository $legacyDataRepository;

    /**
     * @var BaseFormCreator
     */
    protected BaseFormCreator $baseFormCreator;

    /**
     * LegacyDataService constructor.
     *
     * @param LegacyDataRepository $legacyDataRepository
     * @param BaseFormCreator $baseFormCreator
     */
    public function __construct(LegacyDataRepository $legacyDataRepository, BaseFormCreator $baseFormCreator)
    {
        $this->legacyDataRepository = $legacyDataRepository;
        $this->baseFormCreator = $baseFormCreator;
    }

    /**
     * Returns legacy data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getActivityLegacyData(int $activity_id): ?array
    {
        return $this->legacyDataRepository->getActivityLegacyData($activity_id);
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
        return $this->legacyDataRepository->getActivityData($id);
    }

    /**
     * Updates activity legacy.
     *
     * @param $activityLegacy
     * @param $activity
     *
     * @return bool
     */
    public function update($activityLegacy, $activity): bool
    {
        return $this->legacyDataRepository->update($activityLegacy, $activity);
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
        $model['legacy_data'] = $this->getActivityLegacyData($id);
        $this->baseFormCreator->url = route('admin.activities.legacy-data.update', [$id]);

        return $this->baseFormCreator->editForm($model, $element['legacy_data'], 'PUT', '/activities/' . $id);
    }
}
