<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\ContactInfoRepository;
use App\IATI\Traits\XmlBaseElement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Kris\LaravelFormBuilder\Form;

/**
 * Class ContactInfoService.
 */
class ContactInfoService
{
    use XmlBaseElement;

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
        $contacts = (array) $activity->contact_info;

        if (count($contacts)) {
            foreach ($contacts as $contact) {
                $activityData[] = [
                    '@attributes'     => [
                        'type' => Arr::get($contact, 'type', null),
                    ],
                    'organisation'    => [
                        'narrative' => $this->buildNarrative(Arr::get($contact, 'organisation.0.narrative', [])),
                    ],
                    'department'      => [
                        'narrative' => $this->buildNarrative(Arr::get($contact, 'department.0.narrative', [])),
                    ],
                    'person-name'     => [
                        'narrative' => $this->buildNarrative(Arr::get($contact, 'person_name.0.narrative', [])),
                    ],
                    'job-title'       => [
                        'narrative' => $this->buildNarrative(Arr::get($contact, 'job_title.0.narrative', [])),
                    ],
                    'telephone'       => [
                        '@value' => Arr::get($contact, 'telephone.0.telephone', null),
                    ],
                    'email'           => [
                        '@value' => Arr::get($contact, 'email.0.email', null),
                    ],
                    'website'         => [
                        '@value' => Arr::get($contact, 'website.0.website', null),
                    ],
                    'mailing-address' => [
                        'narrative' => $this->buildNarrative(Arr::get($contact, 'mailing_address.0.narrative', [])),
                    ],
                ];
            }
        }

        return $activityData;
    }
}
