<?php

if (!function_exists('translateRequestMessage')) {
    /**
     * Builds translated lines using prefix and suffix of request.php.
     *
     * @param string $prefixKey
     * @param string $suffixKey
     *
     * @return string
     */
    function translateRequestMessage(string $prefixKey, string $suffixKey = ''): string
    {
        if (empty($suffixKey)) {
            return trans('requests.' . $prefixKey);
        }

        return trans('requests.' . $prefixKey, ['suffix' => trans('requests.suffix.' . $suffixKey)]);
    }
}

if (!function_exists('translateJsonValues')) {
    /**
     * Translates json values for the keys: label, placeholder, hover_text & help_text
     * json[obj][label] = 'buttons.delete_confirmation'
     * becomes json[obj][label] = "Are you sure you want to delete item ?".
     *
     * @param $elements
     *
     * @return mixed
     */
    function translateJsonValues($elements): mixed
    {
        $swappableKeys = ['label', 'placeholder', 'hover_text', 'help_text'];
        $result = [];
        if (is_array($elements)) {
            foreach ($elements as $key => $value) {
                if (is_string($value) && in_array($key, $swappableKeys)) {
                    $translated = trans($value);
                    $result[$key] = $translated;
                } else {
                    $result[$key] = translateJsonValues($value);
                }
            }
        } else {
            $result = $elements;
        }

        return $result;
    }
}

if (!function_exists('getLabelForAddAdditional')) {
    /**
     * Returns translated:  Add additional ELEMENT
     * - Example:
     * - Add additional narrative
     * - Add additional description.
     *
     * @param string $element
     *
     * @return string
     */
    function getLabelForAddAdditional(string $element): string
    {
        $element = str_replace('-', ' ', trans("elements_common.$element"));

        return trans('buttons.add_additional', ['element' => $element]);
    }
}

if (!function_exists('translatedElement')) {
    /**
     * Returns translated element
     * - Example: [ EN => FR => ES ]
     * - title      => titre       => título
     * - period end => fin période => fin período.
     *
     * @param string $element
     * @param string $source
     *
     * @return string
     */
    function translatedElement(string $element, string $source = 'element_labels'): string
    {
        return trans_choice("$source.$element", $element);
    }
}

if (!function_exists('translateMidfixSuffix')) {
    /**
     * Returns translated : The ELEMENT SUFFIX
     * - Example:
     * - The Document Link format is invalid.
     * - The CRS Channel Code is invalid.
     *
     * @param string $midfixKey
     * @param string $suffixKey
     *
     * @return string
     */
    function translateMidfixSuffix(string $midfixKey, string $suffixKey):string
    {
        return trans('requests.the_midfix_suffix', ['midfix'=>trans($midfixKey), 'suffix'=>trans($suffixKey)]);
    }
}

/**
 * Returns translated lines from responses.php:
 * - Example:
 * - Import error for activity has been successfully deleted.
 * - Error has occurred while trying to delete import error.
 *
 * @param string $key
 *
 * @return string
 */
function translateResponses(string $key):string
{
    return ucfirst(trans("responses.$key"));
}

/**
 * Returns translated: ELEMENT has been EVENT successfully.
 * - Example:
 * - Title has been updated successfully.
 * - Budget has been deleted successfully.
 *
 * @param string $element
 * @param string $event
 *
 * @return string
 */
function translateElementHasBeenSuccessfully(string $element, string $event): string
{
    $event = trans("events.$event");
    $element = trans("elements_common.$element");

    return ucfirst(trans('responses.has_been_event_successfully', ['prefix' => $element, 'event'=> $event]));
}

/**
 * Returns translated: ELEMENT successfully EVENT.
 * - Example:
 * - Title successfully updated.
 * - Budget successfully deleted.
 *
 * @param string $element
 * @param string $event
 *
 * @return string
 */
function translateElementSuccessfully(string $element, string $event): string
{
    $event = trans("events.$event");
    $element = trans("elements_common.$element");

    return ucfirst(trans('responses.event_successfully', ['prefix' => $element, 'event'=> $event]));
}

/**
 * Returns translated: ELEMENT EVENT failed.
 * - Example:
 * - Title delete failed.
 * - Description update failed.
 *
 * @param string $element
 * @param string $event
 *
 * @return string
 */
function translateElementFailed(string $element, string $event): string
{
    $element = trans($element);
    $event = lcfirst(trans("events.$event"));

    return ucfirst(trans('responses.event_failed', ['prefix' => $element, 'event'=> $event]));
}

/**
 * Returns translated : Error has occurred while EVENT ELEMENT {scope}
 * - Example:
 * - Error has occurred while rendering indicator.
 * - Error has occurred while rendering title form.
 * - Error has occurred while opening activity detail page.
 *
 * @param string $completeElement
 * @param string $event
 * @param string $scope
 *
 * @return string
 */
function translateErrorHasOccurred(string $completeElement, string $event, string $scope = ''): string
{
    $event = trans("events.$event");
    $completeElement = trans("$completeElement");

    if ($scope) {
        $scope = "responses.error_has_occurred_$scope";

        return  ucfirst(trans("$scope", ['event'=> $event, 'suffix' => $completeElement]));
    }

    return  ucfirst(trans('responses.error_has_occurred', ['event'=> $event, 'suffix' => $completeElement]));
}

/**
 * Returns translated: 'ELEMENT delete error'.
 * - Example:
 * - Period delete error.
 *
 * @param string $completeElement
 *
 * @return string
 */
function translateElementDeleteError(string $completeElement): string
{
    return ucwords(trans('responses.delete_error', ['prefix'=>trans("$completeElement")]));
}
