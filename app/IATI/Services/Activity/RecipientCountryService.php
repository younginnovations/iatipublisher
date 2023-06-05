<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\ActivityRepository;
use App\IATI\Services\ElementCompleteService;
use App\IATI\Traits\XmlBaseElement;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Arr;
use JsonException;
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
     * @var RecipientRegionService
     */
    protected RecipientRegionService $recipientRegionService;

    /**
     * @var ElementCompleteService
     */
    protected ElementCompleteService $elementCompleteService;

    /**
     * RecipientCountryService constructor.
     *
     * @param ActivityRepository $activityRepository
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     * @param RecipientRegionService $recipientRegionService
     * @param ElementCompleteService $elementCompleteService
     */
    public function __construct(ActivityRepository $activityRepository, ParentCollectionFormCreator $parentCollectionFormCreator, RecipientRegionService $recipientRegionService, ElementCompleteService $elementCompleteService)
    {
        $this->activityRepository = $activityRepository;
        $this->parentCollectionFormCreator = $parentCollectionFormCreator;
        $this->recipientRegionService = $recipientRegionService;
        $this->elementCompleteService = $elementCompleteService;
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
     * @throws BindingResolutionException
     */
    public function update($id, $activityRecipientCountry): bool
    {
        $data = [
            'recipient_country' => $this->sanitizeRecipientCountryData($activityRecipientCountry),
        ];
        $totalRecipientCountry = $activityRecipientCountry['total_country_percentage'] ?? 0;
        $data = $this->setRecipientRegionStatus((int) $id, $data, $totalRecipientCountry);

        return $this->activityRepository->update($id, $data);
    }

    /**
     * Generates budget form.
     *
     * @param $id
     * @param $element
     *
     * @return Form
     */
    public function formGenerator($id, $element): Form
    {
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

    /**
     * Sets Recipient Region Complete Status if Recipient Country is 100%.
     *
     * @param int $id
     * @param array $data
     * @param $totalRecipientCountry
     *
     * @return array
     *
     * @throws BindingResolutionException
     * @throws JsonException
     */
    public function setRecipientRegionStatus(int $id, array &$data, $totalRecipientCountry): array
    {
        $activity = $this->activityRepository->find($id);
        $currentRecipientRegionPercent = getAllocatedPercentageOfRecipientRegion($activity);
        $totalPercentage = $totalRecipientCountry + $currentRecipientRegionPercent;
        $elementStatus['element_status'] = $activity->element_status;
        $elementStatus['element_status']['recipient_region'] = $totalPercentage === 100.0;

        $data = array_merge($data, $elementStatus);

        return $data;
    }

    /**
     * Gets recipient region first group total percentage.
     *
     * @param $formFields
     * @return int
     */
    public function getRecipientRegionFirstTotalPercentage($formFields): int
    {
        $groupedRecipientRegion = $this->recipientRegionService->groupRegion($formFields);

        return (int) array_sum(array_map(static fn ($item) => $item['total'], $groupedRecipientRegion));
    }
}
