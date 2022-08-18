<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Repositories\Activity\ActivityRepository;
use Kris\LaravelFormBuilder\Form;

/**
 * Class SectorService.
 */
class SectorService
{
    /**
     * @var ActivityRepository
     */
    protected ActivityRepository $activityRepository;

    /**
     * @var ParentCollectionFormCreator
     */
    protected ParentCollectionFormCreator $parentCollectionFormCreator;

    /**
     * SectorService constructor.
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
     * Returns sector data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getSectorData(int $activity_id): ?array
    {
        return $this->activityRepository->find($activity_id)->sector;
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
     * Updates activity sector.
     *
     * @param $sectorActivity
     * @param $activity
     *
     * @return bool
     */
    public function update($sectorActivity, $activity): bool
    {
        return $this->activityRepository->update($activity->id, ['sector' => $this->sanitizeSectorData($sectorActivity)]);
    }

    /**
     * Generates sector form.
     *
     * @param id
     *
     * @return Form
     */
    public function formGenerator($id): Form
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $model['sector'] = $this->getSectorData($id);
        $this->parentCollectionFormCreator->url = route('admin.activity.sector.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element['sector'], 'PUT', '/activity/' . $id);
    }

    /**
     * Sanitizes sector data.
     *
     * @param $activitySector
     *
     * @return array
     */
    public function sanitizeSectorData($activitySector): array
    {
        foreach ($activitySector['sector'] as $key => $sector) {
            $activitySector['sector'][$key]['narrative'] = array_values($sector['narrative']);
        }

        return array_values($activitySector['sector']);
    }
}
