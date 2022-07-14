<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\DescriptionRepository;
use App\IATI\Traits\XmlBaseElement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Kris\LaravelFormBuilder\Form;

/**
 * Class DescriptionService.
 */
class DescriptionService
{
    use XmlBaseElement;

    /**
     * @var DescriptionRepository
     */
    protected DescriptionRepository $descriptionRepository;

    /**
     * @var ParentCollectionFormCreator
     */
    protected ParentCollectionFormCreator $parentCollectionFormCreator;

    /**
     * DescriptionService constructor.
     *
     * @param DescriptionRepository $descriptionRepository
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     */
    public function __construct(DescriptionRepository $descriptionRepository, ParentCollectionFormCreator $parentCollectionFormCreator)
    {
        $this->descriptionRepository = $descriptionRepository;
        $this->parentCollectionFormCreator = $parentCollectionFormCreator;
    }

    /**
     * Returns description data of an activity.
     *s.
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getDescriptionData(int $activity_id): ?array
    {
        return $this->descriptionRepository->getDescriptionData($activity_id);
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
        return $this->descriptionRepository->getActivityData($id);
    }

    /**
     * Updates activity description.
     *
     * @param $descriptionActivity
     * @param $activity
     *
     * @return bool
     */
    public function update($descriptionActivity, $activity): bool
    {
        return $this->descriptionRepository->update($descriptionActivity, $activity);
    }

    /**
     * Generates description form.
     *
     * @param id
     *
     * @return Form
     */
    public function formGenerator($id): Form
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $model['description'] = $this->getDescriptionData($id);
        $this->parentCollectionFormCreator->url = route('admin.activities.description.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element['description'], 'PUT', '/activities/' . $id);
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
        $descriptions = (array) $activity->description;

        if (count($descriptions)) {
            foreach ($descriptions as $description) {
                $activityData[] = [
                    '@attributes' => [
                        'type' => Arr::get($description, 'type', null),
                    ],
                    'narrative'   => $this->buildNarrative(Arr::get($description, 'narrative', null)),
                ];
            }
        }

        return $activityData;
    }
}
