<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\DefaultTiedStatusRepository;
use Illuminate\Database\Eloquent\Model;
use Kris\LaravelFormBuilder\Form;

/**
 * Class DefaultTiedStatusService.
 */
class DefaultTiedStatusService
{
    /**
     * @var DefaultTiedStatusRepository
     */
    protected DefaultTiedStatusRepository $defaultTiedStatusRepository;

    /**
     * @var BaseFormCreator
     */
    protected BaseFormCreator $baseFormCreator;

    /**
     * DefaultTiedStatusService constructor.
     *
     * @param DefaultTiedStatusRepository $defaultTiedStatusRepository
     * @param BaseFormCreator $baseFormCreator
     */
    public function __construct(DefaultTiedStatusRepository $defaultTiedStatusRepository, BaseFormCreator $baseFormCreator)
    {
        $this->defaultTiedStatusRepository = $defaultTiedStatusRepository;
        $this->baseFormCreator = $baseFormCreator;
    }

    /**
     * Returns default tied status data of an activity.
     *
     * @param int $activity_id
     *
     * @return int|null
     */
    public function getDefaultTiedStatusData(int $activity_id): ?int
    {
        return $this->defaultTiedStatusRepository->getDefaultTiedStatusData($activity_id);
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
        return $this->defaultTiedStatusRepository->getActivityData($id);
    }

    /**
     * Updates activity default tied status data.
     *
     * @param $activityDefaultTiedStatus
     * @param $activity
     *
     * @return bool
     */
    public function update($activityDefaultTiedStatus, $activity): bool
    {
        return $this->defaultTiedStatusRepository->update($activityDefaultTiedStatus, $activity);
    }

    /**
     * Generates default tied status form.
     *
     * @param id
     *
     * @return Form
     */
    public function formGenerator($id): Form
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $model['default_tied_status'] = $this->getDefaultTiedStatusData($id);
        $this->baseFormCreator->url = route('admin.activities.default-tied-status.update', [$id]);

        return $this->baseFormCreator->editForm($model, $element['default_tied_status'], 'PUT', '/activities/' . $id);
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

        if ($activity->default_tied_status) {
            $activityData = [
                '@attributes' => [
                    'code' => $activity->default_tied_status,
                ],
            ];
        }

        return $activityData;
    }
}
