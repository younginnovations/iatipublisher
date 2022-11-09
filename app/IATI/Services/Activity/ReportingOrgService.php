<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Elements\Builder\ParentCollectionFormCreator;
use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\ActivityRepository;
use App\IATI\Traits\XmlBaseElement;
use Illuminate\Database\Eloquent\Model;
use Kris\LaravelFormBuilder\Form;

/**
 * Class ReportingOrgService.
 */
class ReportingOrgService
{
    use XmlBaseElement;

    /**
     * @var ActivityRepository
     */
    protected ActivityRepository $activityRepository;

    /**
     * ReportingOrgService constructor.
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
     * Returns reporting org data of an Activity.
     *
     * @param int $Activity_id
     *
     * @return array|null
     */
    public function getReportingOrgData(int $activity_id): ?array
    {
        return $this->activityRepository->find($activity_id)->reporting_org;
    }

    /**
     * Returns Activity object.
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
     * Updates Activity identifier.
     *
     * @param $id
     * @param $reportingOrg
     *
     * @return bool
     */
    public function update($id, $reportingOrg): bool
    {
        foreach ($reportingOrg['reporting_org'] as $key => $description) {
            $reportingOrg['reporting_org'][$key]['narrative'] = array_values($description['narrative']);
        }

        $reportingOrg = array_values($reportingOrg['reporting_org']);

        return $this->activityRepository->update($id, ['reporting_org' => $reportingOrg]);
    }

    /**
     * Generates name form.
     *
     * @param $id
     *
     * @return Form
     */
    public function formGenerator($id): Form
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
        $model['reporting_org'] = $this->getReportingOrgData($id) ?? [];
        $this->parentCollectionFormCreator->url = route('admin.activity.reporting-org.update', [$id]);

        return $this->parentCollectionFormCreator->editForm($model, $element['reporting_org'], 'PUT', '/organisation');
    }

    /**
     * Generates xml data for reporting org.
     *
     * @param Activity $Activity
     *
     * @return array
     */
    public function getXmlData(Activity $activity): array
    {
        $activityData = [];
        $activityReportingOrg = (array) $activity->reporting_org;

        foreach ($activityReportingOrg as $reportingOrg) {
            $activityData[] = [
                '@attributes' => [
                    'type'                  => $reportingOrg['type'],
                    'ref'                   => $reportingOrg['ref'],
                    'secondary-reporter'    => $reportingOrg['secondary_reporter'],
                ],
                'narrative'   => $this->buildNarrative($reportingOrg['narrative']),
            ];
        }

        return $activityData;
    }
}
