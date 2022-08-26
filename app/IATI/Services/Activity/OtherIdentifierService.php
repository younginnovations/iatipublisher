<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\OtherIdentifierRepository;
use App\IATI\Traits\XmlBaseElement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Kris\LaravelFormBuilder\Form;

/**
 * Class OtherIdentifierService.
 */
class OtherIdentifierService
{
    use XmlBaseElement;

    /**
     * @var otherIdentifierRepository
     */
    protected OtherIdentifierRepository $otherIdentifierRepository;

    /**
     * @var ParentCollectionFormCreator
     */
    protected ParentCollectionFormCreator $parentCollectionFormCreator;

    /**
     * OtherIdentifierService constructor.
     *
     * @param OtherIdentifierRepository $otherIdentifierRepository
     * @param ParentCollectionFormCreator $parentCollectionFormCreator
     */
    public function __construct(OtherIdentifierRepository $otherIdentifierRepository, ParentCollectionFormCreator $parentCollectionFormCreator)
    {
        $this->otherIdentifierRepository = $otherIdentifierRepository;
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
        return $this->otherIdentifierRepository->getOtherIdentifierData($activity_id);
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
        return $this->otherIdentifierRepository->getActivityData($id);
    }

    /**
     * Updates activity identifier.
     *
     * @param $activityIdentifier
     * @param $activity
     *
     * @return bool
     */
    public function update($activityIdentifier, $activity): bool
    {
        return $this->otherIdentifierRepository->update($activityIdentifier, $activity);
    }

    /**
     * Generates other identifier form.
     *
     * @param id
     *
     * @return Form
     */
    public function formGenerator($id): Form
    {
        $element = getElementSchema('other_identifier');
        $model = $this->getOtherIdentifierData($id) ?: [];
        $this->parentCollectionFormCreator->url = route('admin.activities.other-identifier.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element, 'PUT', '/activities/' . $id);
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
}
