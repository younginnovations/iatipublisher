<?php

declare(strict_types=1);

namespace App\IATI\Traits;

use App\IATI\Services\Activity\ActivityService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Arr;

trait IatiValidatorResponseTrait
{
    public array $multilevelElements = [
        '/activity/activityId/result/resultId/edit' => 'result',
        '/result/resultId/indicator/indicatorId/edit' => 'indicator',
        '/indicator/indicatorId/period/periodId/edit' => 'period',
        'activity/activityId/transaction/transactionId/edit' => 'transaction',
    ];

    /**
     * @throws \JsonException
     */
    public function addElementOnIatiValidatorResponse($response, $activity)
    {
        $response = json_decode($response, true, 512, JSON_THROW_ON_ERROR);
        $errors = $response['errors'];
        $updatedErrors = [];

        foreach ($errors as $error) {
            if (isset($error['details'][0])) {
                foreach ($error['details'] as $key => $detailedError) {
                    if (isset($detailedError['error']['line'])) {
                        $lineNumber = $detailedError['error']['line'];
                        $nodePath = $this->getNodeByLineNumber($lineNumber, $activity);
                        $errorLocation = str_replace('/', '>', getStringBetween($nodePath, '/', '/edit'));
                        $error['context'][$key]['iati_path'] = $nodePath;
                        $error['context'][$key]['message'] = $errorLocation;
                    }
                }
            } elseif (isset($error['details']['xpathContext'])) {
                $lineNumber = $error['details']['xpathContext']['lineNumber'];
                $nodePath = $this->getNodeByLineNumber($lineNumber, $activity);
                $errorLocation = str_replace('/', '>', getStringBetween($nodePath, '/', '/edit'));
                $error['context'][0]['iati_path'] = $nodePath;
                $error['context'][0]['message'] = $errorLocation;
            }
            $updatedErrors[] = $error;
        }

        $response['errors'] = $updatedErrors;
        $this->clearXmlValidationOnS3($activity);

        return $response;
    }

    /**
     * Clears XML Validation file from s3.
     *
     * @param $activity
     *
     * @return void
     */
    public function clearXmlValidationOnS3($activity): void
    {
        awsDeleteFile("xmlValidation/$activity->org_id/activity_$activity->id.xml");
        awsDeleteFile("xmlValidation/$activity->org_id/activity_mapper_$activity->id.xml");
    }

    /**
     * Pinpoint exact parent xml node and generates url.
     *
     * @param $lineNumber
     * @param $activity
     *
     * @return string|null
     *
     * @throws \JsonException
     * @throws BindingResolutionException
     */
    public function getNodeByLineNumber($lineNumber, $activity): ?string
    {
        $xmlFile = awsGetFile("xmlValidation/$activity->org_id/activity_$activity->id.xml");
        $xml = simplexml_load_string((string) $xmlFile);
        $xmlString = $xml->asXML();
        $xmlLines = explode("\n", $xmlString);
        $lineNumber++;

        if ($lineNumber >= 1 && $lineNumber <= count($xmlLines)) {
            $parentNode = [];

            foreach ($xml->xpath('//iati-activity/* | //iati-activity//@*') as $node) {
                $nodeName = $node->getName();
                $childNodePath = $node->xpath("//$nodeName/*");
                $parentNode[str_replace('/iati-activities/iati-activity/', '', dom_import_simplexml($node)->getNodePath())] = dom_import_simplexml($node)->getLineNo();

                if (!empty($childNodePath)) {
                    foreach ($childNodePath as $childNode) {
                        $domImportSimpleXml = dom_import_simplexml($childNode);
                        $parentNode[str_replace('/iati-activities/iati-activity/', '', $domImportSimpleXml->getNodePath())] = $domImportSimpleXml->getLineNo();
                    }
                }
            }
            asort($parentNode);
            $parentNode = array_flip($parentNode);

            $targetNode = $parentNode[$lineNumber] ?? null;

            if (empty($targetNode)) {
                foreach ($parentNode as $nodeLineNumber => $nodeName) {
                    if ($lineNumber < $nodeLineNumber) {
                        break;
                    }
                    $targetNode = $nodeName;
                }
            }

            if ($targetNode) {
                return $this->generateUrlPath($targetNode, $activity);
            }
        }

        return null;
    }

    /**
     * Generates url path to navigate the error.
     *
     * @param $targetNode
     * @param $activity
     *
     * @return string
     *
     * @throws \JsonException
     * @throws BindingResolutionException
     */
    public function generateUrlPath($targetNode, $activity): string
    {
        $activityId = $activity->id;
        $path = $targetNode;
        $subtractedPath = preg_replace_callback('/\[(\d+)\]/', static function ($matches) {
            return '[' . ($matches[1] - 1) . ']';
        }, $path);
        $explodedPath = explode('/', $subtractedPath);
        $firstElementName = str_replace('-', '_', preg_replace('/[^a-zA-Z-]/', '', $explodedPath[0]));
        $activityMapperFile = awsGetFile("xmlValidation/$activity->org_id/activity_mapper_$activityId.xml");
        $activityTransactionResultMapper = json_decode($activityMapperFile, true, 512, JSON_THROW_ON_ERROR);
        $getId = [];
        $urlPath = [];

        foreach ($explodedPath as $pathNode) {
            $position = filter_var($pathNode, FILTER_SANITIZE_NUMBER_INT);
            $position = str_replace('-', '', $position);
            $elementName = preg_replace('/[^a-zA-Z-]/', '', $pathNode);
            $elementPosition = !empty($position) ? $position : 0;

            if (in_array($elementName, $this->multilevelElements, true)) {
                $getId[$elementName] = $elementPosition;
            } else {
                $elementName = str_replace('-', '_', $elementName);
                $elementName = count($urlPath) ? "[$elementName]" : $elementName;
                $urlPath[] = $elementName . "[$elementPosition]";
            }
        }

        if (array_key_exists('period', $getId)) {
            $resultIdPath = $activityTransactionResultMapper['results'][$getId['result']];
            $indicatorIdPath = $activityTransactionResultMapper['indicators'][$resultIdPath][$getId['indicator']];
            $periodIdPath = $activityTransactionResultMapper['periods'][$indicatorIdPath][$getId['period']];
            $indicatorId = $this->getElementId($indicatorIdPath, $activityId);
            $periodId = $this->getElementId($periodIdPath, $activityId);
            $url = array_flip($this->multilevelElements)['period'];
            $url = str_replace(['indicatorId', 'periodId'], [$indicatorId, $periodId], $url);
        } elseif (array_key_exists('indicator', $getId)) {
            $resultIdPath = $activityTransactionResultMapper['results'][$getId['result']];
            $indicatorIdPath = $activityTransactionResultMapper['indicators'][$resultIdPath][$getId['indicator']];
            $resultId = $this->getElementId($resultIdPath, $activityId);
            $indicatorId = $this->getElementId($indicatorIdPath, $activityId);
            $url = array_flip($this->multilevelElements)['indicator'];
            $url = str_replace(['resultId', 'indicatorId'], [$resultId, $indicatorId], $url);
        } elseif (array_key_exists('result', $getId)) {
            $resultIdPath = $activityTransactionResultMapper['results'][$getId['result']];
            $resultId = $this->getElementId($resultIdPath, $activityId);
            $url = array_flip($this->multilevelElements)['result'];
            $url = str_replace(['activityId', 'resultId'], [$activityId, $resultId], $url);
        } elseif (array_key_exists('transaction', $getId)) {
            $transactionIdPath = $activityTransactionResultMapper['transactions'][$getId['transaction']];
            $transactionId = $this->getElementId($transactionIdPath, $activityId);
            $url = array_flip($this->multilevelElements)['transaction'];
            $url = str_replace(['activityId', 'transactionId'], [$activityId, $transactionId], $url);
        } else {
            $url = "/activity/activityId/$firstElementName/edit";
            $url = str_replace('activityId', (string) $activityId, $url);
        }

        $urlId = implode('', $urlPath);

        return $url . '#' . $urlId;
    }

    /**
     * @param $idPath
     * @param $activityId
     *
     * @return array|\ArrayAccess|mixed
     *
     * @throws BindingResolutionException
     */
    public function getElementId($idPath, $activityId): mixed
    {
        $activityService = app()->make(ActivityService::class);
        $activity = $activityService->getActivitityWithRelationsById($activityId)->toArray();

        return Arr::get($activity, $idPath . '.id');
    }
}
