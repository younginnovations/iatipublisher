<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\DefaultAidTypeRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Kris\LaravelFormBuilder\Form;

/**
 * Class DefaultAidTypeService.
 */
class DefaultAidTypeService
{
    /**
     * @var DefaultAidTypeRepository
     */
    protected DefaultAidTypeRepository $defaultAidTypeRepository;

    /**
     * @var BaseFormCreator
     */
    protected BaseFormCreator $baseFormCreator;

    /**
     * DefaultAidTypeService constructor.
     *
     * @param DefaultAidTypeRepository $defaultAidTypeRepository
     * @param BaseFormCreator $baseFormCreator
     */
    public function __construct(DefaultAidTypeRepository $defaultAidTypeRepository, BaseFormCreator $baseFormCreator)
    {
        $this->defaultAidTypeRepository = $defaultAidTypeRepository;
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
        return $this->defaultAidTypeRepository->getDefaultAidTypeData($activity_id);
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
        return $this->defaultAidTypeRepository->getActivityData($id);
    }

    /**
     * Updates activity default aid type.
     *
     * @param $activityDefaultAidType
     * @param $activity
     *
     * @return bool
     */
    public function update($activityDefaultAidType, $activity): bool
    {
        return $this->defaultAidTypeRepository->update($activityDefaultAidType, $activity);
    }

    /**
     * Generates default aid type.
     *
     * @param id
     *
     * @return Form
     */
    public function formGenerator($id): Form
    {
        $element = getElementSchema('default_aid_type');
        $model['default_aid_type'] = $this->getDefaultAidTypeData($id);
        $this->baseFormCreator->url = route('admin.activities.default-aid-type.update', [$id]);

        return $this->baseFormCreator->editForm($model, $element, 'PUT', '/activities/' . $id);
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
                $vocabulary = Arr::get($aidType, 'default_aidtype_vocabulary', null);

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
