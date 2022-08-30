<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Repositories\Activity\ActivityRepository;
use App\IATI\Traits\XmlBaseElement;
use Kris\LaravelFormBuilder\Form;

/**
 * Class ContactInfoService.
 */
class ContactInfoService
{
    use XmlBaseElement;

    /**
     * @var ActivityRepository
     */
    protected ActivityRepository $activityRepository;

    /**
     * @var ParentCollectionFormCreator
     */
    private ParentCollectionFormCreator $parentCollectionFormCreator;

    /**
     * ContactInfoService constructor.
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
     * @return object
     */
    public function getActivityData($id): object
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
     * @throws \JsonException
     */
    public function update($id, $contactInfo): bool
    {
        $element = getElementSchema('contact_info');

        foreach ($contactInfo['contact_info'] as $key => $contact) {
            foreach (array_keys($element['sub_elements']) as $subElement) {
                $contactInfo['contact_info'][$key][$subElement] = array_values($contact[$subElement]);
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
     * @throws \JsonException
     */
    public function formGenerator($id): Form
    {
        $element = getElementSchema('contact_info');
        $model['contact_info'] = $this->getContactInfoData($id) ?: [];
        $this->parentCollectionFormCreator->url = route('admin.activity.contact-info.update', [$id]);

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
