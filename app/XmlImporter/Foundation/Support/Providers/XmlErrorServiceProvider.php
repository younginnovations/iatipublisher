<?php

namespace App\XmlImporter\Foundation\Support\Providers;

use DOMDocument;

/**
 * Class XmlErrorServiceProvider.
 */
class XmlErrorServiceProvider
{
    /**
     * Load the contents of an Xml file to check if there are any schema errors.
     *
     * @param $contents
     * @return \DOMDocument
     */
    public function load($contents)
    {
        libxml_use_internal_errors(true);
        $document = new DOMDocument();
        $document->loadXML($contents);

        return $document;
    }
}
