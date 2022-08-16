<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Repositories\Activity\DescriptionRepository;
use Illuminate\Database\Eloquent\Model;
use Kris\LaravelFormBuilder\Form;

/**
 * Class DescriptionService.
 */
class DescriptionService
{
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
        $this->parentCollectionFormCreator->url = route('admin.activity.description.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element['description'], 'PUT', '/activity/' . $id);
    }
}
