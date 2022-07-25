<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Repositories\Activity\CapitalSpendRepository;
use Illuminate\Database\Eloquent\Model;
use Kris\LaravelFormBuilder\Form;

/**
 * Class CapitalSpendService.
 */
class CapitalSpendService
{
    /**
     * @var BaseFormCreator
     */
    protected BaseFormCreator $baseFormCreator;

    /**
     * @var CapitalSpendRepository
     */
    protected CapitalSpendRepository $capitalSpendRepository;

    /**
     * CapitalSpendService constructor.
     *
     * @param CapitalSpendRepository $capitalSpendRepository
     * @param BaseFormCreator $baseFormCreator
     */
    public function __construct(CapitalSpendRepository $capitalSpendRepository, BaseFormCreator $baseFormCreator)
    {
        $this->capitalSpendRepository = $capitalSpendRepository;
        $this->baseFormCreator = $baseFormCreator;
    }

    /**
     * Returns capital spend data of an activity.
     *
     * @param int $activity_id
     *
     * @return float|null
     */
    public function getCapitalSpendData(float $activity_id): ?float
    {
        return $this->capitalSpendRepository->getCapitalSpendData($activity_id);
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
        return $this->capitalSpendRepository->getActivityData($id);
    }

    /**
     * Updates activity capital spend data.
     *
     * @param $activityCapitalSpend
     * @param $activity
     *
     * @return bool
     */
    public function update($activityCapitalSpend, $activity): bool
    {
        return $this->capitalSpendRepository->update($activityCapitalSpend, $activity);
    }

    /**
     * Generates capital spend form.
     *
     * @param id
     *
     * @return Form
     */
    public function formGenerator($id): Form
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $model['capital_spend'] = $this->getCapitalSpendData($id);
        $this->baseFormCreator->url = route('admin.activities.capital-spend.update', [$id]);

        return $this->baseFormCreator->editForm($model, $element['capital_spend'], 'PUT', '/activities/' . $id);
    }
}
