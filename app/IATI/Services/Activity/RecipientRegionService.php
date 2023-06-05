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
 * Class RecipientRegionService.
 */
class RecipientRegionService
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
     * @var ElementCompleteService
     */
    protected ElementCompleteService $elementCompleteService;

    /**
     * @var ActivityService
     */
    protected ActivityService $activityService;

    /**
     * RecipientRegionService constructor.
     *
     * @param ActivityRepository $activityRepository
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     * @param ElementCompleteService $elementCompleteService
     */
    public function __construct(ActivityRepository $activityRepository, ParentCollectionFormCreator $parentCollectionFormCreator, ElementCompleteService $elementCompleteService)
    {
        $this->activityRepository = $activityRepository;
        $this->parentCollectionFormCreator = $parentCollectionFormCreator;
        $this->elementCompleteService = $elementCompleteService;
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
        return $this->activityRepository->find($activity_id)->recipient_region;
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
     * Updates activity recipient region.
     *
     * @param $id
     * @param $activityRecipientRegion
     *
     * @return bool
     * @throws BindingResolutionException
     * @throws JsonException
     */
    public function update($id, $activityRecipientRegion): bool
    {
        $data = [
            'recipient_region' => $this->sanitizeRecipientRegionData($activityRecipientRegion),
        ];
        $totalRecipientRegionPercentage = $activityRecipientRegion['total_region_percentage'] ?? 0;
        $data = $this->setRecipientCountryStatus((int) $id, $data, $totalRecipientRegionPercentage);

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
        $model['recipient_region'] = $this->getRecipientRegionData($id);
        $this->parentCollectionFormCreator->url = route('admin.activity.recipient-region.update', [$id]);

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
        $recipientRegions = (array) $activity->recipient_region;

        if (count($recipientRegions)) {
            foreach ($recipientRegions as $recipientRegion) {
                $vocabulary = Arr::get($recipientRegion, 'region_vocabulary', null);

                switch ($vocabulary) {
                    case '1':
                        $code = Arr::get($recipientRegion, 'region_code', null);
                        break;

                    case '2':
                    case '99':
                        $code = Arr::get($recipientRegion, 'custom_code', null);
                        break;

                    default:
                        $code = Arr::get($recipientRegion, 'custom_code', null);
                }

                $activityData[] = [
                    '@attributes' => [
                        'code'           => $code,
                        'percentage'     => Arr::get($recipientRegion, 'percentage', null),
                        'vocabulary'     => $vocabulary,
                        'vocabulary-uri' => Arr::get($recipientRegion, 'vocabulary_uri', null),
                    ],
                    'narrative'   => $this->buildNarrative(Arr::get($recipientRegion, 'narrative', [])),
                ];
            }
        }

        return $activityData;
    }

    /**
     * Sanitizes recipient region data.
     *
     * @param $activityRecipientRegion
     *
     * @return array
     */
    public function sanitizeRecipientRegionData($activityRecipientRegion): array
    {
        foreach ($activityRecipientRegion['recipient_region'] as $key => $recipient_region) {
            $activityRecipientRegion['recipient_region'][$key]['narrative'] = array_values($recipient_region['narrative']);
        }

        return array_values($activityRecipientRegion['recipient_region']);
    }

    /**
     * Sets Recipient Country Complete Status if Recipient Region is 100%.
     *
     * @param int $id
     * @param array $data
     * @param $totalRecipientRegionPercentage
     *
     * @return array
     *
     * @throws BindingResolutionException
     * @throws JsonException
     */
    public function setRecipientCountryStatus(int $id, array &$data, $totalRecipientRegionPercentage): array
    {
        $activity = $this->activityRepository->find($id);
        $currentRecipientCountryPercentage = getAllocatedPercentageOfRecipientCountry($activity);
        $totalPercentage = $totalRecipientRegionPercentage + $currentRecipientCountryPercentage;
        $elementStatus['element_status'] = $activity->element_status;
        $elementStatus['element_status']['recipient_country'] = $totalPercentage === 100.0;

        $data = array_merge($data, $elementStatus);

        return $data;
    }

    /**
     * Calculates total percentage of a country.
     *
     * @param $recipientCountry
     * @return int
     */
    public function countryTotalPercentage($recipientCountry): int
    {
        return array_sum(array_map(static fn ($item) => $item['percentage'], $recipientCountry));
    }

    /**
     * @param $formFields
     *
     * @return array
     */
    public function groupRegion($formFields): array
    {
        $groupedRegion = [];

        foreach ($formFields as $formField) {
            if (array_key_exists($formField['region_vocabulary'], $groupedRegion)) {
                $groupedRegion[$formField['region_vocabulary']]['count'] += 1;
                $groupedRegion[$formField['region_vocabulary']]['total'] += (float) $formField['percentage'];
            } else {
                $groupedRegion[$formField['region_vocabulary']] = ['count' => 1, 'total' => (float) $formField['percentage']];
            }
        }

        return $groupedRegion;
    }
}
