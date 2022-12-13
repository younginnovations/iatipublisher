<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\Period;

use App\Http\Requests\Activity\ActivityBaseRequest;
use App\IATI\Services\Activity\IndicatorService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

/**
 * Class PeriodRequest.
 */
class PeriodRequest extends ActivityBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @throws BindingResolutionException
     */
    public function rules(): array
    {
        return $this->getRulesForPeriod(request()->except(['_token']));
    }

    /**
     * Get the error message as required.
     *
     * @return array
     * @throws BindingResolutionException
     */
    public function messages(): array
    {
        return $this->getMessagesForPeriod(request()->except(['_token']));
    }

    /**
     * Returns rules for result indicator.
     *
     * @param array $formFields
     *
     * @return array
     * @throws BindingResolutionException
     */
    public function getRulesForPeriod(array $formFields, bool $fileUpload = false, array $indicator = []): array
    {
        $rules = [];
        $tempRules = [
            $this->getRulesForResultPeriodStart($formFields['period_start'], 'period_start'),
            $this->getRulesForResultPeriodEnd($formFields['period_end'], 'period_end'),
            $this->getRulesForTarget($formFields['target'], 'target', $fileUpload, $indicator),
            $this->getRulesForTarget($formFields['actual'], 'actual', $fileUpload, $indicator),
        ];

        foreach ($tempRules as $index => $tempRule) {
            foreach ($tempRule as $idx => $rule) {
                $rules[$idx] = $rule;
            }
        }

        return $rules;
    }

    /**
     * Returns messages for result indicator validations.
     *
     * @param array $formFields
     *
     * @return array
     * @throws BindingResolutionException
     */
    public function getMessagesForPeriod(array $formFields, bool $fileUpload = false, array $indicator = []): array
    {
        $messages = [];
        $tempMessages = [
            $this->getMessagesForResultPeriod($formFields['period_start'], 'period_start'),
            $this->getMessagesForResultPeriod($formFields['period_end'], 'period_end'),
            $this->getMessagesForTarget($formFields['target'], 'target', $fileUpload, $indicator),
            $this->getMessagesForTarget($formFields['actual'], 'actual', $fileUpload, $indicator),
        ];

        foreach ($tempMessages as $index => $tempMessage) {
            foreach ($tempMessage as $idx => $message) {
                $messages[$idx] = $message;
            }
        }

        return $messages;
    }

    /**
     * returns rules for period start.
     *
     * @param $formFields
     * @param $periodType
     *
     * @return array
     */
    protected function getRulesForResultPeriodStart($formFields, $periodType): array
    {
        $rules = [];

        foreach ($formFields as $periodStartKey => $periodStartVal) {
            $rules[sprintf('%s.%s.date', $periodType, $periodStartKey)] = 'nullable|date|date_greater_than:1900';
        }

        return $rules;
    }

    /**
     * returns rules for period end.
     *
     * @param $formFields
     * @param $periodType
     *
     * @return array
     */
    protected function getRulesForResultPeriodEnd($formFields, $periodType): array
    {
        $rules = [];

        foreach ($formFields as $periodEndKey => $periodEndVal) {
            $rules[sprintf('%s.%s.date', $periodType, $periodEndKey)] = sprintf('nullable|date|after:%s', 'period_start.' . $periodEndKey . '.date');
        }

        return $rules;
    }

    /**
     * returns messages for period start and period end.
     *
     * @param $formFields
     * @param $periodType
     *
     * @return array
     */
    protected function getMessagesForResultPeriod($formFields, $periodType): array
    {
        $messages = [];

        foreach ($formFields as $periodStartKey => $periodStartVal) {
            $messages[sprintf(
                '%s.%s.date.date',
                $periodType,
                $periodStartKey
            )]
                = 'The @date field must be a proper date.';

            $messages[sprintf(
                '%s.%s.date.after',
                $periodType,
                $periodStartKey
            )]
                = 'The @iso-date field of period end must be a date after @iso-field of period start';

            $messages[sprintf(
                '%s.%s.date.period_start_end',
                $periodType,
                $periodStartKey
            )]
                = 'The @iso-date field of period end and @iso-date of period start must not have difference of more than a year';
        }

        return $messages;
    }

    /**
     * returns rules for Target.
     *
     * @param $formFields
     * @param $valueType
     *
     * @return array
     * @throws BindingResolutionException
     */
    protected function getRulesForTarget($formFields, $valueType, $fileUpload, $indicator): array
    {
        $rules = [];

        if ($fileUpload) {
            $measure = Arr::get($indicator, 'measure');
            $indicatorMeasureType = [
                'qualitative' => $measure === '5',
                'non_qualitative' => in_array($measure, ['1', '2', '3', '4']),
            ];
        } else {
            $params = $this->route()->parameters();
            $indicatorService = app()->make(IndicatorService::class);
            $indicatorMeasureType = $indicatorService->getIndicatorMeasureType($params['id']);
        }

        Validator::extend('qualitative_empty', function () {
            return false;
        });

        foreach ($formFields as $targetIndex => $target) {
            $targetForm = sprintf('%s.%s', $valueType, $targetIndex);
            $narrativeRules = $this->getRulesForNarrative($target['comment'][0]['narrative'], sprintf('%s.comment.0', $targetForm));
            $docLinkRules = $this->getRulesForDocumentLink($target['document_link'], $targetForm);

            foreach ($narrativeRules as $key => $narrativeRule) {
                $rules[$key] = $narrativeRule;
            }

            foreach ($docLinkRules as $key => $docLinkRule) {
                $rules[$key] = $docLinkRule;
            }

            if ($indicatorMeasureType['non_qualitative']) {
                $rules[sprintf('%s.%s.value', $valueType, $targetIndex)] = 'numeric|required';
            } elseif ($indicatorMeasureType['qualitative'] && !empty($target['value'])) {
                $rules[sprintf('%s.%s.value', $valueType, $targetIndex)] = 'qualitative_empty';
            }
        }

        return $rules;
    }

    /**
     * returns messages for target.
     *
     * @param $formFields
     * @param $valueType
     *
     * @return array
     * @throws BindingResolutionException
     */
    protected function getMessagesForTarget($formFields, $valueType, $fileUpload, $indicator): array
    {
        $messages = [];

        if ($fileUpload) {
            $measure = Arr::get($indicator, 'measure');
            $indicatorMeasureType = [
                'qualitative' => $measure === '5',
                'non_qualitative' => in_array($measure, ['1', '2', '3', '4']),
            ];
        } else {
            $params = $this->route()->parameters();
            $indicatorService = app()->make(IndicatorService::class);
            $indicatorMeasureType = $indicatorService->getIndicatorMeasureType($params['id']);
        }

        foreach ($formFields as $targetIndex => $target) {
            $targetForm = sprintf('%s.%s', $valueType, $targetIndex);

            $messages[sprintf('%s.%s.value.numeric', $valueType, $targetIndex)] = 'The @value field must be numeric.';

            $narrativeMessages = $this->getMessagesForNarrative($target['comment'][0]['narrative'], sprintf('%s.comment.0', $targetForm));

            foreach ($narrativeMessages as $key => $narrativeMessage) {
                $messages[$key] = $narrativeMessage;
            }

            $docLinkMessages = $this->getMessagesForDocumentLink($target['document_link'], $targetForm);

            foreach ($docLinkMessages as $key => $docLinkMessage) {
                $messages[$key] = $docLinkMessage;
            }

            if ($indicatorMeasureType['non_qualitative']) {
                $messages[sprintf('%s.%s.value', $valueType, $targetIndex)] = 'Value must be filled when the indicator measure is non-qualitative.';
            } elseif ($indicatorMeasureType['qualitative'] && !empty($target['value'])) {
                $messages[sprintf('%s.%s.value.qualitative_empty', $valueType, $targetIndex)] = 'Value must be omitted when the indicator measure is qualitative.';
            }
        }

        return $messages;
    }
}
