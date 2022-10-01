<?php

declare(strict_types=1);

namespace App\XmlImporter\Foundation\Mapper\Components\Elements;

use App\XmlImporter\Foundation\Support\Helpers\Traits\XmlHelper;
use Illuminate\Support\Arr;

/**
 * Class Result.
 */
class Result
{
    use XmlHelper;

    /**
     * @var
     */
    protected $result;
    /**
     * @var
     */
    protected $indicators;

    /**
     * @param array $results
     * @param       $template
     *
     * @return mixed
     */
    public function map(array $results, $template): mixed
    {
        foreach ($results as $index => $result) {
            $this->result[$index] = $template['result'];
            $this->result[$index]['type'] = $this->attributes($result, 'type');
            $this->result[$index]['aggregation_status'] = $this->attributes($result, 'aggregation-status');
            $this->result[$index]['title'][0]['narrative'] = $this->value(Arr::get($result, 'value', []), 'title');
            $this->result[$index]['description'][0]['narrative'] = $this->value(Arr::get($result, 'value', []), 'description');
            $this->result[$index]['document_link'] = $this->documentLink($result, $index);
            $this->result[$index]['indicator'] = $this->indicator($result, $index);
            $this->result[$index]['reference'] = $this->resultReference($result['value'], [0 => $template['result']]);
        }

        return $this->result;
    }

    /**
     * @param $result
     * @param $index
     * @return array
     */
    protected function indicator($result, $index): array
    {
        $indicatorAttributes = $this->filterAttributes(Arr::get($result, 'value', []), 'indicator', ['measure', 'ascending', 'aggregation_status']);
        $indicators = $this->filterValues(Arr::get($result, 'value', []), 'indicator');
        $indicatorTemplate = Arr::get($this->result[$index], 'indicator', []);
        $indicatorData = [Arr::get($indicatorTemplate, 0, [])];

        foreach ($indicators as $key => $indicator) {
            $indicator = $indicator['indicator'];
            $indicatorData[$key]['measure'] = $indicatorAttributes[$key]['measure'];
            $indicatorData[$key]['ascending'] = $indicatorAttributes[$key]['ascending'];
            $indicatorData[$key]['aggregation_status'] = $indicatorAttributes[$key]['aggregation_status'];
            $indicatorData[$key]['title'][0]['narrative'] = $this->value($indicator, 'title');
            $indicatorData[$key]['description'][0]['narrative'] = $this->value($indicator, 'description');
            $indicatorData[$key]['reference'] = $this->reference($indicator, $indicatorTemplate);
            $indicatorData[$key]['baseline'] = $this->baseline($indicator, $indicatorTemplate, $index);
            $indicatorData[$key]['period'] = $this->period($indicator, $indicatorTemplate, $index);
            $indicatorData[$index]['document_link'] = $this->documentLink(['value' => $indicator], $index);
        }

        return $indicatorData;
    }

    /**
     * @param $indicator
     * @param $indicatorTemplate
     * @return array
     */
    protected function reference($indicator, $indicatorTemplate): array
    {
        $references = $this->filterAttributes($indicator, 'reference', ['vocabulary', 'code', 'indicator_uri']);
        $referenceData = Arr::get($indicatorTemplate, '0.reference');

        foreach ($references as $referenceIndex => $reference) {
            $referenceData[$referenceIndex] = $reference;
        }

        return $referenceData;
    }

    /**
     * @param $result
     * @param $resultTemplate
     * @return array
     */
    protected function resultReference($result, $resultTemplate): array
    {
        $references = $this->filterAttributes($result, 'reference', ['vocabulary', 'code', 'vocabulary-uri']);
        $referenceData = Arr::get($resultTemplate, '0.reference');

        foreach ($references as $referenceIndex => $reference) {
            $referenceData[$referenceIndex] = $reference;
        }

        return $referenceData;
    }

    /**
     * @param $indicator
     * @param $indicatorTemplate
     * @param $index
     *
     * @return array
     */
    protected function baseline($indicator, $indicatorTemplate, $index): array
    {
        $baseline = Arr::get($indicatorTemplate, '0.baseline');
        $baselineAttributes = $this->filterAttributes($indicator, 'baseline', ['year', 'iso-date', 'value']);
        $baseline[0]['year'] = Arr::get($baselineAttributes, '0.year', '');
        $baseline[0]['date'] = Arr::get($baselineAttributes, '0.iso-date', '');
        $baseline[0]['value'] = Arr::get($baselineAttributes, '0.value', '');
        $baselineValues = Arr::get($this->filterValues($indicator, 'baseline'), '0.baseline');
        $baseline[0]['comment'][0]['narrative'] = $this->value($baselineValues, 'comment');
        $baseline[0]['document_link'] = $this->documentLink(['value' => $baselineValues], $index);
        $baseline[0]['location'] = $this->location($baselineValues, $baseline);
        $baseline[0]['dimension'] = $this->dimension($baselineValues, $baseline);

        return $baseline;
    }

    /**
     * @param $indicator
     * @param $indicatorTemplate
     * @param $index
     *
     * @return array
     */
    protected function period($indicator, $indicatorTemplate, $index): array
    {
        $periods = $this->filterValues($indicator, 'period');
        $periodsData = $periodsTemplate = Arr::get($indicatorTemplate, '0.period');

        foreach ($periods as $index => $period) {
            $period = Arr::get($period, 'period', []);
            $periodsData[$index]['period_start'][0]['date'] = Arr::get($this->filterAttributes($period, 'periodStart', ['iso-date']), '0.iso-date', '');
            $periodsData[$index]['period_end'][0]['date'] = Arr::get($this->filterAttributes($period, 'periodEnd', ['iso-date']), '0.iso-date', '');
            $periodsData[$index]['target'] = $this->target($period, $periodsTemplate, $index);
            $periodsData[$index]['actual'] = $this->actual($period, $periodsTemplate, $index);
        }

        return $periodsData;
    }

    /**
     * @param $period
     * @param $periodTemplate
     * @param $index
     *
     * @return array
     */
    protected function target($period, $periodTemplate, $index): array
    {
        $targetData = Arr::get($periodTemplate, '0.target');
        $targetData[0]['value'] = Arr::get($this->filterAttributes($period, 'target', ['value']), '0.value', '');
        $target = Arr::get($this->filterValues($period, 'target'), '0.target', []);
        $targetData[0]['location'] = $this->location($target, $targetData);
        $targetData[0]['dimension'] = $this->dimension($target, $targetData);
        $targetData[0]['comment'] = $this->comment($target, $targetData);
        $targetData[0]['document_link'] = $this->documentLink(['value' => $target], $index);

        return $targetData;
    }

    /**
     * @param $period
     * @param $periodTemplate
     * @param $index
     *
     * @return array
     */
    protected function actual($period, $periodTemplate, $index): array
    {
        $actualData = Arr::get($periodTemplate, '0.actual');
        $actualData[0]['value'] = Arr::get($this->filterAttributes($period, 'actual', ['value']), '0.value', '');
        $actual = Arr::get($this->filterValues($period, 'actual'), '0.actual', []);
        $actualData[0]['location'] = $this->location($actual, $actualData);
        $actualData[0]['dimension'] = $this->dimension($actual, $actualData);
        $actualData[0]['comment'] = $this->comment($actual, $actualData);
        $actualData[0]['document_link'] = $this->documentLink(['value' => $actual], $index);

        return $actualData;
    }

    /**
     * @param $data
     * @param $template
     *
     * @return array
     */
    protected function location($data, $template): array
    {
        $locationData = Arr::get($template, '0.location', []);
        $locations = $this->filterAttributes($data, 'location', ['ref']);

        foreach ($locations as $index => $location) {
            $locationData[$index]['reference'] = Arr::get($location, 'ref');
        }

        return $locationData;
    }

    /**
     * @param $data
     * @param $template
     *
     * @return array
     */
    protected function dimension($data, $template): array
    {
        $dimensionData = Arr::get($template, '0.dimension', []);
        $dimensions = $this->filterAttributes($data, 'dimension', ['name', 'value']);

        foreach ($dimensions as $index => $dimension) {
            $dimensionData[$index]['name'] = Arr::get($dimension, 'name');
            $dimensionData[$index]['value'] = Arr::get($dimension, 'value');
        }

        return $dimensionData;
    }

    /**
     * @param $data
     * @param $template
     *
     * @return array
     */
    protected function comment($data, $template): array
    {
        $commentData = Arr::get($template, '0.comment', []);
        $comments = Arr::get($this->filterValues($data, 'comment'), '0.comment', []);

        foreach ($comments as $index => $comment) {
            $commentData[0]['narrative'][$index] = Arr::get($this->narrative($comment), '0');
        }

        return $commentData;
    }

    /**
     * @param $element
     * @param $index
     *
     * @return array
     */
    public function documentLink($element, $index): array
    {
        $documentLinkAttributes = $this->filterAttributes(Arr::get($element, 'value', []), 'documentLink', ['format', 'url']);
        $documentLinks = $this->filterValues(Arr::get($element, 'value', []), 'documentLink');
        $documentLinkTemplate = Arr::get($this->result[$index], 'document_link', []);
        $documentLinkData = [Arr::get($documentLinkTemplate, 0, [])];

        foreach ($documentLinks as $key => $document) {
            $document = $document['documentLink'];
            $documentLinkData[$key]['url'] = $documentLinkAttributes[$key]['url'];
            $documentLinkData[$key]['format'] = $documentLinkAttributes[$key]['format'];
            $documentLinkData[$key]['title'][0]['narrative'] = (($title = $this->value($document, 'title')) === '') ? $this->emptyNarrative : $title;
            $documentLinkData[$key]['description'][0]['narrative'] = (($title = $this->value($document, 'description')) === '') ? $this->emptyNarrative : $title;
            $documentLinkData[$key]['category'] = $this->filterAttributes($document, 'category', ['code']);

            foreach ($this->filterAttributes($document, 'language', ['code']) as $language_index => $language) {
                $documentLinkData[$key]['language'][$language_index]['language'] = $language['code'];
            }

            $documentLinkData[$key]['document_date'][0]['date'] = dateFormat('Y-m-d', $this->attributes(['value' => $document], 'iso-date', 'documentDate'));
        }

        return $documentLinkData;
    }
}
