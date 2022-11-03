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
 * Class RecipientCountryService.
 */
class RecipientCountryService
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
     * RecipientCountryService constructor.
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
     * @param $id
     * @param $activityRecipientCountry
     *
     * @return bool
     */
    public function update($id, $activityRecipientCountry): bool
    {
        return $this->activityRepository->update($id, ['recipient_country' => $this->sanitizeRecipientCountryData($activityRecipientCountry)]);
    }

    /**
     * Generates budget form.
     *
     * @param $id
     *
     * @return Form
     * @throws \JsonException
     */
    public function formGenerator($id): Form
    {
        $element = getElementSchema('recipient_country');
        $model['recipient_country'] = $this->getRecipientCountryData($id);
        $this->parentCollectionFormCreator->url = route('admin.activity.recipient-country.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element, 'PUT', '/activity/' . $id);
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
        $recipientCountries = (array) $activity->recipient_country;

        if (count($recipientCountries)) {
            foreach ($recipientCountries as $recipientCountry) {
                $activityData[] = [
                    '@attributes' => [
                        'code'       => Arr::get($recipientCountry, 'country_code', null),
                        'percentage' => Arr::get($recipientCountry, 'percentage', null),
                    ],
                    'narrative'   => $this->buildNarrative(Arr::get($recipientCountry, 'narrative', null)),
                ];
            }
        }

        return $activityData;
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
