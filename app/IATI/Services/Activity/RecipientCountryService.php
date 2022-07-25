<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Repositories\Activity\RecipientCountryRepository;
use Illuminate\Database\Eloquent\Model;
use Kris\LaravelFormBuilder\Form;

/**
 * Class RecipientCountryService.
 */
class RecipientCountryService
{
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
}
