<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\RecipientCountryRepository;
use App\IATI\Traits\XmlBaseElement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Kris\LaravelFormBuilder\Form;

/**
 * Class RecipientCountryService.
 */
class RecipientCountryService
{
    use XmlBaseElement;

    /**
     * @var RecipientCountryRepository
     */
    protected RecipientCountryRepository $recipientCountryRepository;

    /**
     * @var ParentCollectionFormCreator
     */
    protected ParentCollectionFormCreator $parentCollectionFormCreator;

    /**
     * RecipientCountryService constructor.
     *
     * @param RecipientCountryRepository $recipientCountryRepository
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     */
    public function __construct(RecipientCountryRepository $recipientCountryRepository, ParentCollectionFormCreator $parentCollectionFormCreator)
    {
        $this->recipientCountryRepository = $recipientCountryRepository;
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
        return $this->recipientCountryRepository->getRecipientCountryData($activity_id);
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
        return $this->recipientCountryRepository->getActivityData($id);
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
        return $this->recipientCountryRepository->update($activityRecipientCountry, $activity);
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
        $this->parentCollectionFormCreator->url = route('admin.activities.recipient-country.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element['recipient_country'], 'PUT', '/activities/' . $id);
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
}
