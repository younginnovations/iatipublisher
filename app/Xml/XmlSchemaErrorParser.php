<?php

declare(strict_types=1);

namespace App\Xml;

use Illuminate\Support\Str;
use SimpleXMLIterator;

class XmlSchemaErrorParser
{
    protected array $mappings = [];

    /**
     * Initialize $mappings.
     */
    public function __construct()
    {
        $this->mappings = [
            '1868'    => trans('requests.xml_parser_1868'),
            '1871'    => trans('requests.xml_parser_1871'),
            'default' => trans('requests.xml_parser_default'),
        ];
    }

    /**
     * get modified message send as per the schema.
     *
     * @param $error
     * @param $validateXml
     *
     * @return mixed|string
     * @throws \Exception
     */
    public function getModifiedError($error, $validateXml): mixed
    {
        $errorLine = $error->line;
        $xmlLines = explode("\n", $validateXml);
        $xmlLines = $this->removeSpace($xmlLines);
        $errorCodeElement = $this->getErrorElementName($xmlLines, $errorLine);
        $elementsInXml = $this->getElementsFromXml($validateXml);
        $mainElement = $this->getMainElement($errorCodeElement, $elementsInXml, $xmlLines, $errorLine);

        return $this->getProperMessage($errorCodeElement, $mainElement, $error);
    }

    /**
     * remove extra space for an xml.
     * @param $xmlLines
     * @return mixed
     */
    protected function removeSpace($xmlLines): mixed
    {
        array_walk_recursive(
            $xmlLines,
            function (&$value) {
                $value = trim(preg_replace('/\s+/', ' ', $value));
            }
        );

        return $xmlLines;
    }

    /**
     * get sub-elements/element code in which error occur.
     * @param $xmlLines
     * @param $errorLine
     * @return mixed
     */
    protected function getErrorElementName($xmlLines, $errorLine): mixed
    {
        $errorCode = substr($xmlLines[$errorLine - 1], 1);
        $errorCode = preg_split('/( |>|<)/', $errorCode);

        return $errorCode[0];
    }

    /**
     * get all the main elements from xml.
     *
     * @param $validateXml
     *
     * @return array
     * @throws \Exception
     */
    protected function getElementsFromXml($validateXml): array
    {
        $parsedXml = new SimpleXMLIterator($validateXml);
        $elements = [];
        foreach ($parsedXml->children()->children() as $key => $data) {
            if ($key !== 'title') {
                $elements[] = $key;
            }
        }

        return $elements;
    }

    /**
     * get main element of specific error.
     * @param $errorCodeElement
     * @param $elementsInXml
     * @param $xmlLines
     * @param $errorLine
     * @return mixed
     */
    protected function getMainElement($errorCodeElement, $elementsInXml, $xmlLines, $errorLine): mixed
    {
        if (in_array($errorCodeElement, $elementsInXml, true)) {
            return $errorCodeElement;
        }

        $errorLine--;
        $errorCodeElement = $this->getErrorElementName($xmlLines, $errorLine);

        return $this->getMainElement($errorCodeElement, $elementsInXml, $xmlLines, $errorLine);
    }

    /**
     * get modified message.
     * @param $errorCodeElement
     * @param $mainElement
     * @param $error
     * @return mixed|string
     */
    protected function getProperMessage($errorCodeElement, $mainElement, $error): mixed
    {
        $mappings = (array_key_exists($error->code, $this->mappings)) ? $this->mappings[$error->code] : $this->mappings['default'];

        if (strtolower($errorCodeElement) === strtolower($mainElement) && (int) $error->code !== 1871) {
            $message = str_replace(':element', ucfirst($errorCodeElement), $mappings);
        } elseif ((int) $error->code === 1871) {
            preg_match("/\( ([a-z\-].+) \)/", $error->message, $matches);
            $missingElem = str_replace('-', ' ', Str::title(!empty($matches) ? $matches[1] : null));
            $message = str_replace(':element', ucfirst($mainElement), $mappings);

            if ($mainElement === 'result' && (strpos($missingElem, 'Indicator') === true)) {
                $message = str_replace(':sub-element', "'Result Indicator'", $message);
            } else {
                $message = str_replace(':sub-element', $missingElem, $message);
            }
        } else {
            $message = str_replace(':element', ucfirst($errorCodeElement), $mappings);
            $message .= ' of ' . ucfirst($mainElement) . ' element.';
        }

        return $message;
    }
}
