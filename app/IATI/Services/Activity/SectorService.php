<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Repositories\Activity\SectorRepository;
use Illuminate\Database\Eloquent\Model;
use Kris\LaravelFormBuilder\Form;

/**
 * Class SectorService.
 */
class SectorService
{
    /**
     * @var SectorRepository
     */
    protected SectorRepository $sectorRepository;

    /**
     * @var ParentCollectionFormCreator
     */
    protected ParentCollectionFormCreator $parentCollectionFormCreator;

    /**
     * SectorService constructor.
     *
     * @param SectorRepository $sectorRepository
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     */
    public function __construct(SectorRepository $sectorRepository, ParentCollectionFormCreator $parentCollectionFormCreator)
    {
        $this->sectorRepository = $sectorRepository;
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
        return $this->sectorRepository->getSectorData($activity_id);
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
        return $this->sectorRepository->getActivityData($id);
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
        return $this->sectorRepository->update($sectorActivity, $activity);
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
}
