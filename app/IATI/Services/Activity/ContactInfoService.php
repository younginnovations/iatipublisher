<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Repositories\Activity\ActivityRepository;
use Illuminate\Database\Eloquent\Model;
use Kris\LaravelFormBuilder\Form;

/**
 * Class ContactInfoService.
 */
class ContactInfoService
{
    /**
     * @var ActivityRepository
     */
    protected ActivityRepository $activityRepository;

    /**
     * ContactInfoService constructor.
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
     * Returns contact info data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getContactInfoData(int $activity_id): ?array
    {
        return $this->activityRepository->find($activity_id)->contact_info;
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
        return $this->activityRepository->find($id);
    }

    /**
     * Updates activity contact info.
     *
     * @param $id
     * @param $contactInfo
     *
     * @return bool
     */
    public function update($id, $contactInfo): bool
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true)['contact_info'];

        foreach ($contactInfo['contact_info'] as $key => $contact) {
            foreach (array_keys($element['sub_elements']) as $subelement) {
                $contactInfo['contact_info'][$key][$subelement] = array_values($contact[$subelement]);
            }
        }

        return $this->activityRepository->update($id, ['contact_info' => $contactInfo['contact_info']]);
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
        $this->parentCollectionFormCreator->url = route('admin.activity.contact-info.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element['contact_info'], 'PUT', '/activity/' . $id);
    }
}
