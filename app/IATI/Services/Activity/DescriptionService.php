<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Repositories\Activity\ActivityRepository;
use App\IATI\Traits\XmlBaseElement;
use Kris\LaravelFormBuilder\Form;

/**
 * Class DescriptionService.
 */
class DescriptionService
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
     * DescriptionService constructor.
     *
     * @param ActivityRepository          $activityRepository
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     */
    public function __construct(ActivityRepository $activityRepository, ParentCollectionFormCreator $parentCollectionFormCreator)
    {
        $this->activityRepository = $activityRepository;
        $this->parentCollectionFormCreator = $parentCollectionFormCreator;
    }

    /**
     * Returns description data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getDescriptionData(int $activity_id): ?array
    {
        return $this->activityRepository->find($activity_id)->description;
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
     * Updates activity description.
     *
     * @param $descriptionActivity
     * @param $activity
     *
     * @return bool
     */
    public function update($descriptionActivity, $activity): bool
    {
        return $this->activityRepository->update($activity->id, ['description' => $this->sanitizeDescriptionData($descriptionActivity)]);
    }

    /**
     * Generates description form.
     *
     * @param $id
     *
     * @return Form
     * @throws \JsonException
     */
    public function formGenerator($id): Form
    {
        $element = getElementSchema('description');
        $model['description'] = $this->getDescriptionData($id);
        $this->parentCollectionFormCreator->url = route('admin.activity.description.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element, 'PUT', '/activity/' . $id);
    }

    /**
     * Sanitizes description data.
     *
     * @param $activityDescription
     *
     * @return array
     */
    public function sanitizeDescriptionData($activityDescription): array
    {
        foreach ($activityDescription['description'] as $key => $description) {
            $activityDescription['description'][$key]['narrative'] = array_values($description['narrative']);
        }

        return array_values($activityDescription['description']);
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
