<?php

use Illuminate\Support\Str;

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
            return trans("requests.$prefixKey");
        }

        return trans("requests.$prefixKey", ['suffix' => trans("requests.suffix.$suffixKey")]);
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
     * - Example: [ EN | FR | ES ]
     *      - title | titre | título
     *      - period end | fin période | fin período.
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
     * - Example : translateMidfixSuffix('common.document_link', 'requests.suffix.format_is_invalid')
     *      - [EN] The Document Link format is invalid.
     *      - [FR] Le/la Lien vers le document format invalide.
     *      - [ES] El/la Enlace del documento el formato es inválido.
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

if (!function_exists('translateResponses')) {
    /**
     * Returns translated lines from responses.php:
     * - Example: translateResponses('no_activities_selected')
     *      - [EN] No activities selected.
     *      - [FR] Aucune activité sélectionnée."
     *      - [ES] No se han seleccionado actividades.
     *
     * @param string $key
     *
     * @return string
     */
    function translateResponses(string $key):string
    {
        return ucfirst(trans("responses.$key"));
    }
}

if (!function_exists('translateElementHasBeenSuccessfully')) {
    /**
     * Returns translated: ELEMENT has been EVENT successfully.
     * - Example 1: translateElementHasBeenSuccessfully('activity', 'created')
     *      - [EN] Activity has been created successfully.
     *      - [FR] Activité a été créé avec succès.
     *      - [ES] Actividad ha sido creado con éxito.
     *
     * - Example 2: translateElementHasBeenSuccessfully('responses.the_data', 'retrieved')
     *      - [EN] The data has been retrieved successfully.
     *      - [FR] Les données a été extrait avec succès.
     *      - [ES] Los datos ha sido recuperado con éxito.
     *
     *
     *
     * @param string $element
     * @param string $event
     *
     * @return string
     */
    function translateElementHasBeenSuccessfully(string $element = '', string $event = ''): string
    {
        $event = Str::contains($event, '.') ? trans("$event") : trans("events.$event");

        if ($element) {
            $element = Str::contains($element, '.') ? trans("$element") : trans("elements_common.$element");
        }

        return ucfirst(trans('responses.has_been_event_successfully', ['prefix' => $element, 'event'=> $event]));
    }
}

if (!function_exists('translateElementSuccessfully')) {
    /**
     * Returns translated: ELEMENT successfully EVENT.
     * - Example 1 : translateElementSuccessfully('language', 'fetched')
     *      - [EN] Language fetched successfully.
     *      - [FR] Langue récupéré réussi.
     *      - [ES] Idioma búsqueda completada con éxito.
     *
     * - Example 2 : translateElementSuccessfully('elements_common.organisation', 'published')
     *      - [EN] Organisation published successfully.
     *      - [FR] Organisation publié réussi.
     *      - [ES] Organización publicado con éxito.
     *
     * @param string $element
     * @param string $event
     *
     * @return string
     */
    function translateElementSuccessfully(string $element = '', string $event = ''): string
    {
        $event = Str::contains($event, '.') ? trans("$event") : trans("events.$event");

        if ($element) {
            $element = Str::contains($element, '.') ? trans("$element") : trans("elements_common.$element");
        }

        return ucfirst(trans('responses.event_successfully', ['prefix' => $element, 'event'=> $event]));
    }
}

if (!function_exists('translateElementFailed')) {
    /**
     * Returns translated: ELEMENT EVENT failed.
     * - Example 1:
     *      - [EN] Activity delete failed.
     *      - [FR] Échec activité supprimer."
     *      - [ES] Fallo en eliminar actividad.
     *
     * - Example 2 : translateElementFailed('elements_common.activities', 'validation')
     *      - [EN] Activities validation failed.
     *      - [FR] Échec activités validation.
     *      - [ES] Fallo en validación actividades.
     *
     * @param string $element
     * @param string $event
     *
     * @return string
     */
    function translateElementFailed(string $element = '', string $event = ''): string
    {
        $event = Str::contains($event, '.') ? trans("$event") : lcfirst(trans("events.$event"));

        if ($element) {
            $element = Str::contains($element, '.') ? trans("$element") : trans("elements_common.$element");
        }

        return ucfirst(trans('responses.event_failed', ['prefix' => $element, 'event'=> $event]));
    }
}

if (!function_exists('translateErrorHasOccurred')) {
    /**
     * Returns translated : Error has occurred while EVENT ELEMENT {scope}
     * - Example 1 : translateErrorHasOccurred('indicator', 'rendering')
     *      - [EN] Error has occurred while rendering indicator.
     *      - [FR] Erreur sur interprétation indicateur.
     *      - [ES] Se ha producido un error representando indicador.
     *
     * - Example 2 : translateErrorHasOccurred('elements_common.title', 'opening', 'form')
     *      - [EN]Error has occurred while rendering title form.
     *      - [FR]Erreur sur le formulaire ouverture titre.
     *      - [ES]Se ha producido un error abriendo formulario de título.
     *
     * - Example 3 : translateErrorHasOccurred('responses.activity_detail', 'opening', 'page')
     *      - [EN] Error has occurred while opening activity detail page.
     *      - [FR] Erreur sur la page ouverture informations concernant l’activité.
     *      - [ES] Se ha producido un error abriendo página de detalles de la actividad.
     *
     * @param string $element
     * @param string $event
     * @param string $scope
     *
     * @return string
     */
    function translateErrorHasOccurred(string $element, string $event, string $scope = ''): string
    {
        $event = Str::contains($event, '.') ? trans("$event") : trans("events.$event");

        if ($element) {
            $element = Str::contains($element, '.') ? trans("$element") : trans("elements_common.$element");
        }

        if ($scope) {
            $scope = "responses.error_has_occurred_$scope";

            return  ucfirst(trans("$scope", ['event'=> $event, 'suffix' => $element]));
        }

        return  ucfirst(trans('responses.error_has_occurred', ['event'=> $event, 'suffix' => $element]));
    }
}

if (!function_exists('translateElementDeleteError')) {
    /**
     * Returns translated: 'ELEMENT delete error'.
     * - Example : translateElementDeleteError('elements_common.period')
     *      - [EN] Period Delete Error.
     *      - [FR] Erreur De Suppression Période.
     *      - [ES] Período Borrar Error.
     *
     * @param string $completeElement
     *
     * @return string
     */
    function translateElementDeleteError(string $completeElement): string
    {
        return ucwords(trans('responses.delete_error', ['prefix'=>trans("$completeElement")]));
    }
}

if (!function_exists('translateCommonError')) {
    /**
     * Returns translated text associated with key.
     * Users common.php as the source of said text.
     * - Example 1 : translateCommonError('this_activity_has_been_duplicated')
     *      - [EN] This Activity has been duplicated in the uploaded Csv File.
     *      - [FR] Cette activité a été dupliquée dans le fichier CSV téléversé.
     *      - [ES] Se ha duplicado esta actividad en el archivo CSV cargado.
     *
     * - Example 2 : translateCommonError('element_doesnt_exist_in_iati_registry', 'user.user')
     *      - [EN] User doesn't exist in IATI Registry.
     *      - [FR] Utilisateur n’existe pas dans le registre de l’IITA.
     *      - [ES] Usuario no existe en el Registro de la IATI.
     *
     * @param string $primaryKey
     * @param string $elementKey
     *
     * @return string
     */
    function translateCommonError(string $primaryKey, string $elementKey = ''): string
    {
        if ($elementKey) {
            return trans("common.error.$primaryKey", ['element'=>trans($elementKey)]);
        }

        return trans("common.error.$primaryKey");
    }
}

if (!function_exists('translateButton')) {
    /**
     * Returns translated text associated with key.
     * Uses buttons.php as the source for said text.
     * - Example 1: translateButton('delete_element', 'common.alert')
     *      - [EN] Delete Alert
     *      - [FR] Supprimer Alerte
     *      - [ES] Eliminar Alerta.
     *
     * - Example 2: translateButton('cancel')
     *      - [EN] Cancel
     *      - [FR] Annuler
     *      - [ES] Cancelar        |
     *
     * @param string $key
     * @param string $element
     *
     * @return string
     */
    function translateButton(string $key, string $element = ''): string
    {
        if ($element) {
            return  ucfirst(trans("buttons.$key", ['element'=>trans($element)]));
        }

        return ucfirst(trans("buttons.$key"));
    }
}

if (!function_exists('translateDoesntExist')) {
    /**
     * Translates the text: ELEMENT doesn't exist.
     * - Example : translateDoesntExist('common.activity')
     *      - [EN] Activity doesn't exist.
     *      - [FR] Activité n’existe pas.
     *      - [ES] Actividad no existe.
     *
     * @param string $element
     *
     * @return string
     */
    function translateDoesntExist(string $element): string
    {
        return trans('middleware.does_not_exist', ['prefix'=>trans($element)]);
    }
}

if (!function_exists('translateCommon')) {
    /**
     * Returns translated value associated with key.
     * Uses common.php as the source for said keys.
     * - Example 1 : translateCommon('missing.not_available')
     *      - [EN] Not available
     *      - [FR] Indisponible
     *      - [ES] No disponible.
     *
     * - Example 2 : translateCommon('title')
     *      - [EN] Title
     *      - [FR] Titre
     *      - [ES] Título
     *
     * @param string $key
     *
     * @return string
     */
    function translateCommon(string $key): string
    {
        return trans("common.$key");
    }
}
