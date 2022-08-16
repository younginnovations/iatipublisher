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
 * Class SectorService.
 */
class SectorService
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
     * SectorService constructor.
     *
     * @param ActivityRepository          $activityRepository
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     */
    public function __construct(ActivityRepository $activityRepository, ParentCollectionFormCreator $parentCollectionFormCreator)
    {
        $this->activityRepository          = $activityRepository;
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
     * @param $id
     * @param $sectorActivity
     *
     * @return bool
     */
    public function update($id, $sectorActivity): bool
    {
        return $this->activityRepository->update($id, ['sector' => $this->sanitizeSectorData($sectorActivity)]);
    }

    /**
     * Generates sector form.
     *
     * @param id
     *
     * @return Form
     * @throws \JsonException
     */
    public function formGenerator($id): Form
    {
        $element                                = getElementSchema('sector');
        $model['sector']                        = $this->getSectorData($id);
        $this->parentCollectionFormCreator->url = route('admin.activity.sector.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element, 'PUT', '/activity/'.$id);
    }

    /**
     * Returns data in required xml array format.
     *
     * @param Activity $activity
     *
     * @return array
     */
    public function getXmlData(Activity $activity)
    {
        $activityData = [];
        $sectors      = (array)$activity->sector;

        if (count($sectors)) {
            foreach ($sectors as $sector) {
                $vocabulary = Arr::get($sector, 'sector_vocabulary', null);

                switch ($vocabulary) {
                    case '1':
                        $sectorValue = Arr::get($sector, 'code', null);
                        break;
                    case '2':
                        $sectorValue = Arr::get($sector, 'category_code', null);
                        break;
                    case '7':
                        $sectorValue = Arr::get($sector, 'sdg_goal', null);
                        break;
                    case '8':
                        $sectorValue = Arr::get($sector, 'sdg_target', null);
                        break;
                    default:
                        $sectorValue = Arr::get($sector, 'text', null);
                        break;
                }

                $activityData[] = [
                    '@attributes' => [
                        'code'           => $sectorValue,
                        'percentage'     => Arr::get($sector, 'percentage', null),
                        'vocabulary'     => $vocabulary,
                        'vocabulary-uri' => Arr::get($sector, 'vocabulary_uri', null),
                    ],
                    'narrative'   => $this->buildNarrative(Arr::get($sector, 'narrative', null)),
                ];
            }
        }

        return $activityData;
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
