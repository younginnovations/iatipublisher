<?php

declare(strict_types=1);

namespace App\IATI\Traits;

use App\IATI\Models\Activity\Activity;
use App\IATI\Models\Activity\Indicator;
use App\IATI\Models\Activity\Period;
use App\IATI\Models\Activity\Result;
use Illuminate\Support\Arr;

/**
 * Class EditFormTrait.
 */
trait EditFormTrait
{
    /**
     * Returns string for form header.
     * Wrapped by css class: overflow-hidden ellipsis__title
     * Example:
     * Add Document link for Activity 1.
     * Edit Document link for Activity 1.
     *
     * @param $hasData
     * @param $elementName
     * @param $parentTitle
     *
     * @return string
     */
    protected function getFormHeader($hasData, $elementName, $parentTitle): string
    {
        $elementName = ucfirst(str_replace('_', ' ', $elementName));

        if ($hasData) {
            return sprintf('Edit %s for %s', $elementName, $parentTitle);
        }

        return sprintf('Add %s for %s', $elementName, $parentTitle);
    }

    protected function basicBreadCrumbInfo(Activity $activity, string $elementName): array
    {
        $activityId = Arr::get($activity, 'id');
        $activityTitle = Arr::get($activity, 'title.0.narrative') ?? 'Untitled Activity';
        $activityTitle = substr($activityTitle, 0, 32);

        return [
            $activityTitle                               => "/activity/$activityId",
            ucwords(str_replace('_', ' ', $elementName)) => "/activity/$activityId#$elementName",
        ];
    }

    protected function resultBreadCrumbInfo(Activity $activity, ?Result $result): array
    {
        $activityId = Arr::get($activity, 'id');
        $activityTitle = Arr::get($activity, 'title.0.narrative') ?? 'Untitled Activity';
        $activityTitle = substr($activityTitle, 0, 32);

        $resultTitle = 'Untitled Result';
        $resultPath = 'result/create';

        if ($result) {
            $resultTitle = Arr::get($result, 'result.title.0.narrative.0.narrative') ?? $resultTitle;
            $resultTitle = substr($resultTitle, 0, 32);
            $resultId = Arr::get($result, 'id');
            $resultPath = "result/$resultId";
        }

        return [
            $activityTitle => "/activity/$activityId",
            'Result List'  => "/activity/$activityId/result",
            $resultTitle   => "/activity/$activityId/$resultPath",
        ];
    }

    protected function indicatorBreadCrumbInfo(Activity $activity, Result $result, ?Indicator $indicator): array
    {
        $activityId = Arr::get($activity, 'id');
        $activityTitle = Arr::get($activity, 'title.0.narrative') ?? 'Untitled Activity';
        $activityTitle = substr($activityTitle, 0, 32);
        $resultTitle = 'Untitled Result';
        $resultTitle = Arr::get($result, 'result.title.0.narrative.0.narrative') ?? $resultTitle;
        $resultTitle = substr($resultTitle, 0, 32);
        $resultId = Arr::get($result, 'id');
        $resultPath = "result/$resultId";

        $indicatorTitle = 'Untitled Indicator';
        $indicatorPath = 'indicator/create';

        if ($indicator) {
            $indicatorTitle = Arr::get($indicator, 'indicator.title.0.narrative.0.narrative') ?? $indicatorTitle;
            $indicatorTitle = substr($indicatorTitle, 0, 32);
            $indicatorId = Arr::get($indicator, 'id', '#');
            $indicatorPath = "indicator/$indicatorId";
        }

        return [
            $activityTitle   => "/activity/$activityId",
            'Result List'    => "/activity/$activityId/result",
            $resultTitle     => "/activity/$activityId/$resultPath",
            'Indicator List' => "/result/$resultId/indicator",
            $indicatorTitle  => "/result/$resultId/$indicatorPath",
        ];
    }

    protected function periodBreadCrumbInfo(
        Activity $activity,
        Result $result,
        Indicator $indicator,
        ?Period $period
    ): array {
        $activityId = Arr::get($activity, 'id');
        $activityTitle = Arr::get($activity, 'title.0.narrative') ?? 'Untitled Activity';
        $activityTitle = substr($activityTitle, 0, 32);
        $resultTitle = 'Untitled Result';
        $resultId = '#';
        $indicatorTitle = 'Untitled Indicator';
        $indicatorId = '#';
        $periodTitle = 'New Period';
        $periodId = 'create';

        if ($result) {
            $resultTitle = Arr::get($result, 'result.title.0.narrative.0.narrative') ?? $resultTitle;
            $resultTitle = substr($resultTitle, 0, 32);
            $resultId = Arr::get($result, 'id', $resultId);
        }

        if ($indicator) {
            $indicatorTitle = Arr::get($indicator, 'indicator.title.0.narrative.0.narrative') ?? $indicatorTitle;
            $indicatorTitle = substr($indicatorTitle, 0, 32);
            $indicatorId = Arr::get($indicator, 'id', '#');
        }

        if ($period) {
            $periodTitle = 'Period';
            $periodId = Arr::get($period, 'id') ?? $period;
        }

        return [
            $activityTitle   => "/activity/$activityId",
            'Result List'    => "/activity/$activityId/result",
            $resultTitle     => "/activity/$activityId/result/$resultId",
            'Indicator List' => "/result/$resultId/indicator",
            $indicatorTitle  => "/result/$resultId/indicator/$indicatorId",
            'Period List'    => "/indicator/$indicatorId/period",
            $periodTitle     => "/indicator/$indicatorId/period/$periodId",
        ];
    }

    protected function transactionBreadCrumbInfo($activity, $transaction): array
    {
        $activityId = Arr::get($activity, 'id');
        $activityTitle = Arr::get($activity, 'title.0.narrative');
        $activityTitle = substr($activityTitle, 0, 32);

        return [
            $activityTitle => "/activity/$activityId",
            'Transactions' => "/activity/$activityId/transaction",
        ];
    }
}
