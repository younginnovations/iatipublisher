<?php

declare(strict_types=1);

namespace App\IATI\Traits;

use App\IATI\Services\Activity\ActivityService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Arr;

/**
 * IatiValidatorResponseTrait.
 */
trait IatiValidatorResponseTrait
{
    /**
     * elements path to be replaced.
     *
     * @var array|string[]
     */
    public array $multilevelElements = [
        '/activity/activityId/result/resultId/edit' => 'result',
        '/result/resultId/indicator/indicatorId/edit' => 'indicator',
        '/indicator/indicatorId/period/periodId/edit' => 'period',
        '/activity/activityId/transaction/transactionId/edit' => 'transaction',
    ];

    /**
     * Pinpoint the error location and appends in the IATI validator response.
     *
     * @param $response
     * @param $activity
     *
     * @return array
     *
     * @throws \JsonException
     */
    public function addElementOnIatiValidatorResponse($response, $activity): array
    {
        $response = json_decode($response, true, 512, JSON_THROW_ON_ERROR);
        $errors = $response['errors'];
        $updatedErrors = [];

        if (!empty($errors)) {
            foreach ($errors as $error) {
                $updatedErrors[] = $this->getValidatorErrors($activity, $error);
            }

            $response['errors'] = $updatedErrors;
            $this->clearXmlValidationOnS3($activity);
        }

        return $response;
    }

    /**
     * Validator Error message with path and message.
     *
     * @param $activity
     * @param $error
     *
     * @return array
     */
    public function getValidatorErrors($activity, $error): array
    {
        $errorMessage = $error['message'];
        $details = $error['details'];

        if (isset($details[0])) {
            foreach ($error['details'] as $key => $detailedError) {
                if (isset($detailedError['error']['line'])) {
                    $detailWithErrorLine = $this->getDetailWithErrorLineResponse($detailedError, $activity);
                    $error['response'][$key]['iati_path'] = $detailWithErrorLine['iati_path'];
                    $error['response'][$key]['message'] = $detailWithErrorLine['message'];
                }
            }
        } elseif (isset($details['caseContext']['paths']) && !empty($details['caseContext']['paths'])) {
            foreach ($error['details']['caseContext']['paths'] as $caseContext => $detailedErrors) {
                if (isset($detailedErrors['lineNumber'])) {
                    $caseContextErrorResponse = $this->getCaseContextErrorResponse($detailedErrors, $activity, $errorMessage);
                    $error['response'][$caseContext]['iati_path'] = $caseContextErrorResponse['iati_path'];
                    $error['response'][$caseContext]['message'] = $caseContextErrorResponse['message'];
                }
            }
        } elseif (!empty($details['caseContext']['less']) || !empty($details['caseContext']['start'])) {
            $getCaseContextStartErrorResponse = $this->getCaseContextStartErrorResponse($error, $activity, $errorMessage);
            $error['response'][0]['iati_path'] = $getCaseContextStartErrorResponse['iati_path'];
            $error['response'][0]['message'] = $getCaseContextStartErrorResponse['message'];
        } elseif (isset($details['xpathContext']['lineNumber'])) {
            $errorResponse = $this->getXpathContextWithLineNumberErrorResponse($error, $activity, $errorMessage);
            $error['response'][0]['iati_path'] = $errorResponse['iati_path'];
            $error['response'][0]['message'] = $errorResponse['message'];
        } elseif (isset($error['details']['xpath'])) {
            $lastSegment = str_replace('//iati-activity/', '', $error['details']['xpath']);
            $lastSegment = in_array($lastSegment, ['@budget-not-provided', '@humanitarian', '@hierarchy']) ? 'default_values' : $lastSegment;
            $error['response'][0]['iati_path'] = checkUrlExists("/activity/$activity->id/$lastSegment") ? "/activity/$activity->id/$lastSegment" : "/activity/$activity->id";
            $error['response'][0]['message'] = "activity>$activity->id";
        } else {
            $error['response'][0]['iati_path'] = "/activity/$activity->id";
            $error['response'][0]['message'] = "activity>$activity->id";
        }

        return $error;
    }

    /**
     * Returns Node path location.
     *
     * @param $nodePath
     *
     * @return string
     */
    public function getErrorLocation($nodePath): String
    {
        if (strpos($nodePath, 'edit')) {
            $stringBetween = getStringBetween($nodePath, '/', '/edit');
        } else {
            $stringBetween = getStringBetween($nodePath, '/', '#');
        }

        return str_replace('/', '>', $stringBetween);
    }

    /**
     * Returns response of a iati validator error whose response has line number in detail.
     *
     * @param $detailedError
     * @param $activity
     *
     * @return array
     *
     * @throws BindingResolutionException
     * @throws \JsonException
     */
    public function getDetailWithErrorLineResponse($detailedError, $activity): array
    {
        $lineNumber = $detailedError['error']['line'];
        $nodePath = $this->getNodeByLineNumber($lineNumber + 1, $activity);
        $errorLocation = $this->getErrorLocation($nodePath);

        return [
            'iati_path' => checkUrlExists($nodePath) ? $nodePath : "/activity/$activity->id",
            'message' => $errorLocation,
        ];
    }

    /**
     * Returns response of a iati validator error whose response has line number in caseContextPath.
     *
     * @param $detailedErrors
     * @param $activity
     * @param $errorMessage
     *
     * @return array
     *
     * @throws BindingResolutionException
     * @throws \JsonException
     */
    public function getCaseContextErrorResponse($detailedErrors, $activity, $errorMessage): array
    {
        $lineNumber = $detailedErrors['lineNumber'];
        $nodePath = $this->getNodeByLineNumber($lineNumber, $activity);

        if ($lineNumber <= 3 && preg_match('(default currency|default language|default hierarchy|budget not provided|humanitarian)', $errorMessage)) {
            $nodePath = "/activity/$activity->id/default_values";
            $errorLocation = "activity>$activity->id>default_values";
        } else {
            $errorLocation = $this->getErrorLocation($nodePath);
        }

        return [
            'iati_path' => checkUrlExists($nodePath) ? $nodePath : "/activity/$activity->id",
            'message' => $errorLocation,
        ];
    }

    /**
     * iati validator error message whose response has start or less in case context path.
     *
     * @param $error
     * @param $activity
     * @param $errorMessage
     *
     * @return array
     *
     * @throws BindingResolutionException
     * @throws \JsonException
     */
    public function getCaseContextStartErrorResponse($error, $activity, $errorMessage): array
    {
        $detailedErrors = $error['details']['caseContext']['less'] ?? $error['details']['caseContext']['start'];
        $lineNumber = $detailedErrors['lineNumber'];
        $nodePath = $this->getNodeByLineNumber($lineNumber, $activity);

        if ($lineNumber <= 3 && preg_match('(default currency|default language|default hierarchy|budget not provided|humanitarian)', $errorMessage)) {
            $nodePath = "/activity/$activity->id/default_values";
            $errorLocation = "activity>$activity->id>default_values";
        } else {
            $errorLocation = $this->getErrorLocation($nodePath);
        }

        return [
            'iati_path' => checkUrlExists($nodePath) ? $nodePath : "/activity/$activity->id",
            'message' => $errorLocation,
        ];
    }

    /**
     * Iati validator error whose response has line number in xpathcontext.
     *
     * @param $error
     * @param $activity
     * @param $errorMessage
     *
     * @return array
     *
     * @throws BindingResolutionException
     * @throws \JsonException
     */
    public function getXpathContextWithLineNumberErrorResponse($error, $activity, $errorMessage): array
    {
        $lineNumber = $error['details']['xpathContext']['lineNumber'];
        $nodePath = $this->getNodeByLineNumber($lineNumber, $activity);

        if ($lineNumber <= 3 && preg_match('(default currency|default language|default hierarchy|budget not provided|humanitarian)', $errorMessage)) {
            $nodePath = "/activity/$activity->id/default_values";
            $errorLocation = "activity>$activity->id>default_values";
        } else {
            $errorLocation = $this->getErrorLocation($nodePath);
        }

        return [
            'iati_path' => checkUrlExists($nodePath) ? $nodePath : "/activity/$activity->id",
            'message' => $errorLocation,
        ];
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
                $elementName = $this->replaceUrlString($elementName, $explodedPath);
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
        } elseif ($targetNode === '@budget-not-provided') {
            $url = "/activity/$activityId/default_values";
        } else {
            $firstElementNameValue = in_array($firstElementName, ['hierarchy', 'budget_not_provided', 'humanitarian']) ? 'default_values' : $firstElementName;
            $url = "/activity/activityId/$firstElementNameValue";
            $url = str_replace('activityId', (string) $activityId, $url);
        }

        $implodedUrlPath = implode('', $urlPath);
        $urlId = $implodedUrlPath !== 'budget_not_provided[0]' ? '#' . $implodedUrlPath : '';
        $urlId = strReplaceLastOccurrence('[0]', '', $urlId); // removed last extra position

        return $url . $urlId;
    }

    /**
     * Replaces required url string.
     *
     * @param $elementName
     * @param $explodedPath
     *
     * @return string
     */
    public function replaceUrlString($elementName, $explodedPath): String
    {
        $replaceStringWith = [
            'vocabulary' => [
                'sector' => 'sector_vocabulary',
                'tag'    => 'tag_vocabulary',
                'default_aid_type' => 'default_aid_type_vocabulary',
                'recipient_region' => 'region_vocabulary',
            ],
            'value' => 'budget_value',
            'iso_date' => 'date',
            'code' => [
                'sector' => 'text',
                'recipient_country' => 'country_code',
            ],
            'xmllang' => 'language',
        ];

        if (!array_key_exists($elementName, $replaceStringWith) || count($explodedPath) === 1) {
            return $elementName;
        }

        $firstKey = str_replace('-', '_', $explodedPath[0]);
        $firstKeyString = str_contains($firstKey, '[') ? substr($firstKey . '[', 0, strpos($firstKey, '[')) : $firstKey;

        $getReplacement = $replaceStringWith[$elementName];

        if (!is_array($getReplacement)) {
            return $getReplacement;
        }

        return $getReplacement[$firstKeyString] ?? $elementName;
    }

    /**
     * Get activity element by id with relations.
     *
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