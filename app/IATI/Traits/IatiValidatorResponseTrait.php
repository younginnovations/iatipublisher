<?php

declare(strict_types=1);

namespace App\IATI\Traits;

trait IatiValidatorResponseTrait
{
    /**
     * @throws \JsonException
     */
    public function addElementOnIatiValidatorResponse($response, $activity)
    {
        $response = json_decode($response, true, 512, JSON_THROW_ON_ERROR);
        $errors = $response['errors'];
        $updatedErrors = [];

        foreach ($errors as $error) {
            if (isset($error['details'][0]['error']['line'])) {
                $lineNumber = $error['details'][0]['error']['line'];
                $error['element'] = $this->getNodeByLineNumber($lineNumber, $activity);
            }
            $updatedErrors[] = $error;
        }

        $response['errors'] = $updatedErrors;

        return $response;
    }

    public function getNodeByLineNumber($lineNumber, $activity): ?string
    {
        $xmlFile = awsGetFile("xmlValidation/$activity->org_id/activity_$activity->id.xml");
        $xml = simplexml_load_string((string) $xmlFile);
        $xmlString = $xml->asXML();
        $xmlLines = explode("\n", $xmlString);

        if ($lineNumber >= 1 && $lineNumber <= count($xmlLines)) {
            $targetLine = $xmlLines[$lineNumber];
            $targetNode = null;

            foreach ($xml->xpath('//iati-activity/*') as $node) {
                if (str_contains($node->asXML(), trim($targetLine))) {
                    $targetNode = $node;

                    break;
                }
            }

            if ($targetNode) {
                return $targetNode->getName();
            }
        }

        return null;
    }
}
