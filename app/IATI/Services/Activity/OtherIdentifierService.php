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
 * Class OtherIdentifierService.
 */
class OtherIdentifierService
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
     * OtherIdentifierService constructor.
     *
     * @param ActivityRepository              $activityRepository
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     */
    public function __construct(ActivityRepository $activityRepository, ParentCollectionFormCreator $parentCollectionFormCreator)
    {
        $this->activityRepository = $activityRepository;
        $this->parentCollectionFormCreator = $parentCollectionFormCreator;
    }

    /**
     * Returns other identifier data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getOtherIdentifierData(int $activity_id): ?array
    {
        return $this->activityRepository->find($activity_id)->other_identifier;
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
     * Updates activity identifier.
     *
     * @param $id
     * @param $activityIdentifier
     *
     * @return bool
     */
    public function update($id, $activityIdentifier): bool
    {
        $activity = $this->activityRepository->find($id);
        $deprecationStatusMap = $activity->deprecation_status_map;

        $deprecationStatusMap['other_identifier'] = doesOtherIdentifierHaveDeprecatedCode($activityIdentifier);

        return $this->activityRepository->update($id, [
            'other_identifier' => $this->sanitizeOtherIdentifierData($activityIdentifier),
            'deprecation_status_map' => $deprecationStatusMap,
        ]);
    }

    /**
     * Generates other identifier form.
     *
     * @param $id
     * @param $activityDefaultFieldValues
     * @param $deprecationStatusMap
     * @return Form
     * @throws \JsonException
     */
    public function formGenerator($id, $activityDefaultFieldValues, $deprecationStatusMap): Form
    {
        $element = getElementSchema('other_identifier');
        $model['other_identifier'] = $this->getOtherIdentifierData($id) ?: [];
        $this->parentCollectionFormCreator->url = route('admin.activity.other-identifier.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element, 'PUT', '/activity/' . $id, $activityDefaultFieldValues, deprecationStatusMap: $deprecationStatusMap);
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
        $otherIdentifiers = (array) $activity->other_identifier;

        if (count($otherIdentifiers)) {
            foreach ($otherIdentifiers as $otherIdentifier) {
                $activityData[] = [
                    '@attributes' => [
                        'ref'  => Arr::get($otherIdentifier, 'reference', null),
                        'type' => Arr::get($otherIdentifier, 'reference_type', null),
                    ],
                    'owner-org'   => [
                        '@attributes' => [
                            'ref' => Arr::get($otherIdentifier, 'owner_org.0.ref', null),
                        ],
                        'narrative'   => $this->buildNarrative(Arr::get($otherIdentifier, 'owner_org.0.narrative', null)),
                    ],
                ];
            }
        }

        return $activityData;
    }

    /**
     * Sanitizes other identifier data.
     *
     * @param $activityIdentifier
     *
     * @return array
     */
    public function sanitizeOtherIdentifierData($activityIdentifier): array
    {
        foreach ($activityIdentifier as $index => $other_identifier) {
            $activityIdentifier[$index]['owner_org'] = array_values($other_identifier['owner_org']);

            foreach ($other_identifier['owner_org'] as $owner_index => $owner_value) {
                $activityIdentifier[$index]['owner_org'][$owner_index]['narrative'] = array_values($owner_value['narrative']);
            }
        }

        return array_values($activityIdentifier);
    }
}
