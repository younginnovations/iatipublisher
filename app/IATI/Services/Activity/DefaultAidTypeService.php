<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\ActivityRepository;
use Illuminate\Support\Arr;
use Kris\LaravelFormBuilder\Form;

/**
 * Class DefaultAidTypeService.
 */
class DefaultAidTypeService
{
    /**
     * @var ActivityRepository
     */
    protected ActivityRepository $activityRepository;

    /**
     * @var BaseFormCreator
     */
    protected BaseFormCreator $baseFormCreator;

    /**
     * DefaultAidTypeService constructor.
     *
     * @param ActivityRepository $activityRepository
     * @param BaseFormCreator    $baseFormCreator
     */
    public function __construct(ActivityRepository $activityRepository, BaseFormCreator $baseFormCreator)
    {
        $this->activityRepository = $activityRepository;
        $this->baseFormCreator = $baseFormCreator;
    }

    /**
     * Returns default aid type data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getDefaultAidTypeData(int $activity_id): ?array
    {
        return $this->activityRepository->find($activity_id)->default_aid_type;
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
     * Updates activity default aid type.
     *
     * @param $id
     * @param $activityDefaultAidType
     *
     * @return bool
     */
    public function update($id, $activityDefaultAidType): bool
    {
        $activityDefaultAidType = array_values($activityDefaultAidType['default_aid_type']);
        $activity = $this->activityRepository->find($id);
        $deprecationStatusMap = $activity->deprecation_status_map;
        $deprecationStatusMap['default_aid_type'] = doesDefaultAidTypeHaveDeprecatedCode($activityDefaultAidType);

        return $this->activityRepository->update($id, [
            'default_aid_type'   => $activityDefaultAidType,
            'deprecation_status_map' => $deprecationStatusMap,
        ]);
    }

    /**
     * Generates default aid type.
     *
     * @param $id
     *
     * @return Form
     * @throws \JsonException
     */
    public function formGenerator($id, $activityDefaultFieldValues, $deprecationStatusMap = []): Form
    {
        $element = getElementSchema('default_aid_type');
        $model['default_aid_type'] = $this->getDefaultAidTypeData($id);
        $this->baseFormCreator->url = route('admin.activity.default-aid-type.update', [$id]);

        return $this->baseFormCreator->editForm($model, $element, 'PUT', '/activity/' . $id, overRideDefaultFieldValue: $activityDefaultFieldValues, deprecationStatusMap: $deprecationStatusMap);
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
        $aidTypeArray = (array) $activity->default_aid_type;

        if (count($aidTypeArray)) {
            foreach ($aidTypeArray as $aidType) {
                $vocabulary = Arr::get($aidType, 'default_aid_type_vocabulary', null);

                switch ($vocabulary) {
                    case '1':
                        $code = Arr::get($aidType, 'default_aid_type', null);
                        break;
                    case '2':
                        $code = Arr::get($aidType, 'earmarking_category', null);
                        break;
                    case '3':
                        $code = Arr::get($aidType, 'earmarking_modality', null);
                        break;
                    case '4':
                        $code = Arr::get($aidType, 'cash_and_voucher_modalities', null);
                        break;
                    default:
                        $code = Arr::get($aidType, 'default_aid_type', null);
                }

                $activityData[] = [
                    '@attributes' => [
                        'code'       => $code,
                        'vocabulary' => $vocabulary,
                    ],
                ];
            }
        }

        return $activityData;
    }
}
