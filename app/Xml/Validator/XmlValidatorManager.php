<?php

namespace App\Xml\Validator;

use App\Xml\Validator\V202\XmlValidator as V202XmlValidator;
use App\Xml\Validator\V203\XmlValidator as V203XmlValidator;
use Illuminate\Foundation\Application;

class XmlValidatorManager
{
    /**
     * Get validator for specified version.
     *
     * @param string $version
     * @return Application|mixed
     */
    public function getValidatorFor($version)
    {
        if ($version == 'V203') {
            return app(V203XmlValidator::class);
        }

        return app(V202XmlValidator::class);
    }
}
