<?php

declare(strict_types=1);

namespace App\IATI\Traits;

/**
 * Class XmlServiceTrait.
 */
trait XmlServiceTrait
{
    /**
     * return xml validation message with type.
     *
     * @param $error
     *
     * @return string
     */
    protected function libxml_display_error($error): string
    {
        $return = '';

        switch ($error->level) {
            case LIBXML_ERR_WARNING:
                $return .= "Warning $error->code:";
                break;
            case LIBXML_ERR_ERROR:
                $return .= "Error $error->code:";
                break;
            case LIBXML_ERR_FATAL:
                $return .= "Fatal Error $error->code:";
                break;
        }

        $return .= trim($error->message);
        $return .= "in  line no. <a href='#$error->line'><b>$error->line</b></a>";

        return $return;
    }

    /**
     * return xml validation error messages.
     *
     * @return array
     */
    protected function libxml_fetch_errors(): array
    {
        return libxml_get_errors();
    }

    /**
     * return xml validation error messages.
     *
     * @return array
     */
    protected function libxml_display_errors(): array
    {
        $errors = libxml_get_errors();
        $messages = [];

        foreach ($errors as $error) {
            $messages[$error->line] = $this->libxml_display_error($error);
        }

        libxml_clear_errors();

        return $messages;
    }
}
