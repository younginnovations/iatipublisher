<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\SectorRepository;
use App\IATI\Traits\XmlBaseElement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Kris\LaravelFormBuilder\Form;

/**
 * Class SectorService.
 */
class SectorService
{
    use XmlBaseElement;

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
        $element = getElementSchema('sector');
        $model['sector'] = $this->getSectorData($id);
        $this->parentCollectionFormCreator->url = route('admin.activities.sector.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element, 'PUT', '/activities/' . $id);
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
        $sectors = (array) $activity->sector;

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
}
