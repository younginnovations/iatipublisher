<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Repositories\Activity\ActivityRepository;
use Kris\LaravelFormBuilder\Form;

/**
 * Class RecipientCountryService.
 */
class RecipientCountryService
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
     * RecipientCountryService constructor.
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
     * Returns recipient country data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getRecipientCountryData(int $activity_id): ?array
    {
        return $this->activityRepository->find($activity_id)->recipient_country;
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
     * Updates activity recipient country.
     *
     * @param $activityRecipientCountry
     * @param $activity
     *
     * @return bool
     */
    public function update($activityRecipientCountry, $activity): bool
    {
        return $this->activityRepository->update($activity->id, ['recipient_country' => $this->sanitizeRecipientCountryData($activityRecipientCountry)]);
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
        $model['recipient_country'] = $this->getRecipientCountryData($id);
        $this->parentCollectionFormCreator->url = route('admin.activity.recipient-country.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element['recipient_country'], 'PUT', '/activity/' . $id);
    }

    /**
     * Sanitizes recipient country data.
     *
     * @param $activityRecipientCountry
     *
     * @return array
     */
    public function sanitizeRecipientCountryData($activityRecipientCountry): array
    {
        foreach ($activityRecipientCountry['recipient_country'] as $key => $recipient_country) {
            $activityRecipientCountry['recipient_country'][$key]['narrative'] = array_values($recipient_country['narrative']);
        }

        return array_values($activityRecipientCountry['recipient_country']);
    }
}
