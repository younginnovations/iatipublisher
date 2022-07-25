<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Repositories\Activity\ContactInfoRepository;
use Illuminate\Database\Eloquent\Model;
use Kris\LaravelFormBuilder\Form;

/**
 * Class ContactInfoService.
 */
class ContactInfoService
{
    /**
     * @var ContactInfoRepository
     */
    protected ContactInfoRepository $contactInfoRepository;

    /**
     * ContactInfoService constructor.
     *
     * @param ContactInfoRepository $contactInfoRepository
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     */
    public function __construct(ContactInfoRepository $contactInfoRepository, ParentCollectionFormCreator $parentCollectionFormCreator)
    {
        $this->contactInfoRepository = $contactInfoRepository;
        $this->parentCollectionFormCreator = $parentCollectionFormCreator;
    }

    /**
     * Returns contact info data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getContactInfoData(int $activity_id): ?array
    {
        return $this->contactInfoRepository->getContactInfoData($activity_id);
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
        return $this->contactInfoRepository->getActivityData($id);
    }

    /**
     * Updates activity contact info.
     *
     * @param $contactInfo
     * @param $activity
     *
     * @return bool
     */
    public function update($contactInfo, $activity): bool
    {
        return $this->contactInfoRepository->update($contactInfo, $activity);
    }

    /**
     * Generates contact info form.
     *
     * @param id
     *
     * @return Form
     */
    public function formGenerator($id): Form
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $model['contact_info'] = $this->getContactInfoData($id) ?: [];
        $this->parentCollectionFormCreator->url = route('admin.activities.contact-info.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element['contact_info'], 'PUT', '/activities/' . $id);
    }
}
