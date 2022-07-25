<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\MultilevelSubElementFormCreator;
use App\IATI\Repositories\Activity\OtherIdentifierRepository;
use Illuminate\Database\Eloquent\Model;
use Kris\LaravelFormBuilder\Form;

/**
 * Class OtherIdentifierService.
 */
class OtherIdentifierService
{
    /**
     * @var otherIdentifierRepository
     */
    protected OtherIdentifierRepository $otherIdentifierRepository;

    /**
     * @var MultilevelSubElementFormCreator
     */
    protected MultilevelSubElementFormCreator $multilevelSubElementFormCreator;

    /**
     * OtherIdentifierService constructor.
     *
     * @param OtherIdentifierRepository $otherIdentifierRepository
     * @param MultilevelSubElementFormCreator $multilevelSubElementFormCreator
     */
    public function __construct(OtherIdentifierRepository $otherIdentifierRepository, MultilevelSubElementFormCreator $multilevelSubElementFormCreator)
    {
        $this->otherIdentifierRepository = $otherIdentifierRepository;
        $this->multilevelSubElementFormCreator = $multilevelSubElementFormCreator;
    }

    /**
     * Returns other identifier data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getOtherIdentifierData(int $activity_id): ?array
    {
        return $this->otherIdentifierRepository->getOtherIdentifierData($activity_id);
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
        return $this->otherIdentifierRepository->getActivityData($id);
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
        return $this->otherIdentifierRepository->update($activityIdentifier, $activity);
    }

    /**
     * Generates other identifier form.
     *
     * @param id
     *
     * @return Form
     */
    public function formGenerator($id): Form
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $model = $this->getOtherIdentifierData($id) ?: [];
        $this->multilevelSubElementFormCreator->url = route('admin.activities.other-identifier.update', [$id]);

        return $this->multilevelSubElementFormCreator->editForm($model, $element['other_identifier'], 'PUT', '/activities/' . $id);
    }
}
