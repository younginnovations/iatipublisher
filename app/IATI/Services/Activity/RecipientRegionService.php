<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Repositories\Activity\RecipientRegionRepository;
use Illuminate\Database\Eloquent\Model;
use Kris\LaravelFormBuilder\Form;

/**
 * Class RecipientRegionService.
 */
class RecipientRegionService
{
    /**
     * @var RecipientRegionRepository
     */
    protected RecipientRegionRepository $recipientRegionRepository;

    /**
     * @var ParentCollectionFormCreator
     */
    protected ParentCollectionFormCreator $parentCollectionFormCreator;

    /**
     * RecipientRegionService constructor.
     *
     * @param RecipientRegionRepository $recipientRegionRepository
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     */
    public function __construct(RecipientRegionRepository $recipientRegionRepository, ParentCollectionFormCreator $parentCollectionFormCreator)
    {
        $this->recipientRegionRepository = $recipientRegionRepository;
        $this->parentCollectionFormCreator = $parentCollectionFormCreator;
    }

    /**
     * Returns recipient region data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getRecipientRegionData(int $activity_id): ?array
    {
        return $this->recipientRegionRepository->getRecipientRegionData($activity_id);
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
        return $this->recipientRegionRepository->getActivityData($id);
    }

    /**
     * Updates activity recipient region.
     *
     * @param $activityRecipientRegion
     * @param $activity
     *
     * @return bool
     */
    public function update($activityRecipientRegion, $activity): bool
    {
        return $this->recipientRegionRepository->update($activityRecipientRegion, $activity);
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
        $model['recipient_region'] = $this->getRecipientRegionData($id);
        $this->parentCollectionFormCreator->url = route('admin.activities.recipient-region.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element['recipient_region'], 'PUT', '/activities/' . $id);
    }
}
