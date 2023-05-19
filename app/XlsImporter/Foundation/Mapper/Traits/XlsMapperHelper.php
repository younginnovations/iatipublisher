<?php

declare(strict_types=1);

namespace App\XlsImporter\Foundation\Mapper\Traits;

use Illuminate\Support\Arr;

/**
 * Trait XlsMapperHelper.
 */
trait XlsMapperHelper
{
    /**
     * Returns content of linearized-activity json file which contains mapping of system field name to column name present in xls sheet.
     *
     * @return array
     */
    public function getLinearizedActivity(): array
    {
        return json_decode(file_get_contents(app_path() . '/XlsImporter/Templates/linearized-activity.json'), true, 512, 0);
    }

    /**
     * Returns content of field-dependencies json file which maps the dependency of element and subelement on attributes and other fields.
     *
     * @return array
     */
    public function getDependencies(): array
    {
        return json_decode(file_get_contents(app_path() . '/XlsImporter/Templates/field-dependencies.json'), true, 512, 0);
    }

    /**
     * Returns content of dropdown-field which contains list of all the select fields and corresponding file that contains the dropdown options.
     *
     * @return array
     */
    public function getDropDownFields(): array
    {
        return json_decode(file_get_contents(app_path() . '/XlsImporter/Templates/dropdown-fields.json'), true, 512, 0);
    }

    /**
     * Returns content of excel-column-name-mapper which contains column name and column position in excel file.
     *
     * @return array
     */
    public function getExcelColumnNameMapper(): array
    {
        return json_decode(file_get_contents(app_path('/XlsImporter/Templates/excel-column-name-mapper.json')), true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * Returns content of activity-template which contains basic structure of element and subelement in the system.
     *
     * @return array
     */
    public function getActivityTemplate(): array
    {
        return json_decode(file_get_contents(app_path() . '/XlsImporter/Templates/activity-template.json'), true, 512, 0);
    }

    /**
     * Maps the dropdown values to their corresponding keys.
     *
     * @return mixed
     */
    public function mapDropDownValueToKey($value, $location, $fieldName): mixed
    {
        $booleanFieldList = readJsonFile('XlsImporter/Templates/boolean-field-list.json');

        // should we consider case(capital and lower)?
        if (is_null($value)) {
            return $value;
        }

        if (is_array($location)) {
            if (is_bool($value)) {
                return (int) $value;
            }

            if (array_key_exists($fieldName, $booleanFieldList) && is_string($value) && in_array(strtolower($value), ['false', 'true', 'no', 'yes', '0', '1'])) {
                return (int) filter_var($value, FILTER_VALIDATE_BOOLEAN);
            }

            foreach ($location as $locationIndex => $locationValue) {
                if ($locationValue === $value) {
                    return $locationIndex;
                }
            }

            return $value;
        }

        $locationArr = explode('/', $location);

        $dropDownValues = array_flip(getCodeList(explode('.', $locationArr[1])[0], $locationArr[0]));
        $key = Arr::get($dropDownValues, $value, $value);

        return $key;
    }

    /**
     * Checks if the peer attributes of an attributes are not empty.
     *
     * @return bool
     */
    public function checkIfPeerAttributesAreNotEmpty(array $peerAttributes, array $rowContent): bool
    {
        foreach ($peerAttributes as $attributeName) {
            $attributeContent = Arr::get($rowContent, $attributeName, null);

            if (!is_null($attributeContent)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if excel row is not empty.
     *
     * @return bool
     */
    public function checkRowNotEmpty($row): bool
    {
        foreach (array_values($row) as $content) {
            if (is_numeric($content) || $content) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns position of a field in the element.
     *
     * @return string
     */
    public function getElementPosition($fieldDependency, $dependencies): string
    {
        $position = '';
        $dependency = explode(' ', $dependencies);
        $expected_position = '';

        foreach ($dependency as $key) {
            $expected_position = empty($expected_position) ? $key : "$expected_position $key";

            if (in_array($expected_position, array_keys($fieldDependency))) {
                $key = $key === 'narrative' ? '0.narrative' : $key;
                $positionValue = $fieldDependency[$expected_position] ?? 0;
                $position = empty($position) ? $key . '.' . $positionValue : "$position.$key.$positionValue";
            } else {
                $position = empty($position) ? "$key" : "$position.$key";
            }
        }

        return $position;
    }

    /**
     * Stores validated data to valid.json file.
     *
     * @param $processedXlsData
     * @param $errors
     * @param $existingIdentifier
     *
     * @return void
     */
    public function storeValidatedData($processedXlsData, $errors, $existingIdentifier, $identifier, $parentIdentifier = null, $code = null): void
    {
        $fileData = awsGetFile($this->validatedDataFilePath);
        $currentContents = $fileData ? json_decode(awsGetFile($this->validatedDataFilePath), true, 512, JSON_THROW_ON_ERROR) : [];
        $currentContents[] = [
            'data' => $processedXlsData,
            'errors' => $errors,
            'existing' => $existingIdentifier,
            'parentIdentifier' => $parentIdentifier,
            'code' => $code,
            'identifier' => $identifier,
            'status' => 'processed',
        ];
        $content = json_encode($currentContents, JSON_THROW_ON_ERROR);
        $status = json_encode([
            'success' => true,
            'message' => 'Processing',
            'total_count' => $this->totalCount,
            'processed_count' => $this->processedCount,
        ]);

        awsUploadFile($this->validatedDataFilePath, $content);
        awsUploadFile($this->statusFilePath, $status);
    }

    public function updateStatus(): void
    {
        $status = json_encode([
            'success' => true,
            'message' => 'Complete',
            'total_count' => $this->totalCount,
            'processed_count' => $this->processedCount,

        ]);

        awsUploadFile($this->statusFilePath, $status);
    }

    /**
     * Appends the cell position of data on error message.
     *
     * @param $errors
     * @param $excelColumnAndRowName
     *
     * @return array
     */
    public function appendExcelColumnAndRowDetail($errors, $excelColumnAndRowName): array
    {
        foreach ($errors as $errorLevel => $errorData) {
            if (count($errorData)) {
                foreach ($errorData as $element => $error) {
                    foreach ($error as $key => $err) {
                        if (isset($excelColumnAndRowName[$key])) {
                            $errors[$errorLevel][$element][$key] = 'Error detected on ' . $excelColumnAndRowName[$key]['sheet'] . ' sheet, cell ' . $excelColumnAndRowName[$key]['cell'] . ':' . $errors[$errorLevel][$element][$key];
                        }
                    }
                }
            } else {
                unset($errors[$errorLevel]);
            }
        }

        return $errors;
    }

    public function checkElementAddMore($elementBase, $elementBasePeer, $elementAddMore, $dependentOnValue, $fieldName, $fieldValue, $baseCount, $parentBaseCount, $row, $element): array
    {
        if ($elementBase && ($fieldName === $elementBase && ($fieldValue || is_numeric($fieldValue) || is_bool($fieldValue) || $this->checkIfPeerAttributesAreNotEmpty($elementBasePeer, $row)))) {
            if (!$elementAddMore) {
                if ($baseCount === 0 || $baseCount > 0) {
                    $this->tempErrors["$element > $this->rowCount"] =
                        empty($elementBasePeer) ?
                        sprintf('Error detected on %s sheet, row %s : The %s cannot have multiple %s.', $this->sheetName, $this->rowCount, $element, $elementBase) :
                        sprintf('Error detected on %s sheet, row %s : The %s cannot have multiple %s or %s.', $this->sheetName, $this->rowCount, $element, implode(', ', $elementBasePeer), $elementBase);
                }
            }

            $baseCount = is_null($baseCount) || !$elementAddMore ? 0 : $baseCount + 1;
            $parentBaseCount = array_fill_keys(array_keys($parentBaseCount), null);
            $dependentOnValue = array_fill_keys(array_keys($dependentOnValue), null);
        }

        return [
            $baseCount,
            $parentBaseCount,
            $dependentOnValue,
        ];
    }

    public function checkSubElementAddMore($fieldDependency, $parentBaseCount, $parentDependentOn, $dependentOnValue, $fieldName, $fieldValue, $row): array
    {
        if (array_key_exists($fieldName, $fieldDependency)) {
            $parentKey = $fieldDependency[$fieldName]['parent'];
            $peerAttributes = Arr::get($fieldDependency, "$fieldName.peer", []);
            $children = Arr::get($fieldDependency, "$fieldName.children", []);
            $parentAddMore = Arr::get($fieldDependency, "$fieldName.add_more", true);

            if ($fieldValue || is_numeric($fieldValue) || is_bool($fieldValue) || $this->checkIfPeerAttributesAreNotEmpty($peerAttributes, $row)) {
                $parentBaseCount[$parentKey] = is_null($parentBaseCount[$parentKey]) || !$parentAddMore ? 0 : $parentBaseCount[$parentKey] + 1;

                foreach ($children as $child) {
                    $parentBaseCount[$child] = null;
                }

                if (array_key_exists($parentKey, $parentDependentOn)) {
                    foreach ($parentDependentOn[$parentKey] as $dependencyIndex) {
                        $dependentOnValue[$dependencyIndex] = null;
                    }
                }
            }
        }

        return [
            $parentBaseCount,
            $dependentOnValue,
        ];
    }

    public function addProcessingErrors($parentIdentifier, $identifier)
    {
        if (!empty($this->tempErrors)) {
            foreach ($this->tempErrors as $index => $errors) {
                $this->processingErrors[$parentIdentifier][$identifier][$index] = $errors;
            }
        }
    }

    public function storeGlobalErrors()
    {
        $status = json_encode([
            'success' => true,
            'message' => 'Complete',
            'total_count' => count($this->globalErrors),
            'errors' => $this->globalErrors,

        ]);

        awsUploadFile($this->globalErrorFilePath, $status);
    }

    public function isIdentifierDuplicate($elementIdentifier, $element, $validate = false, $type = null): bool
    {
        if (in_array($elementIdentifier, Arr::get($this->trackIdentifierBySheet, $this->sheetName, []))) {
            $this->tempErrors["$element > $this->rowCount"] = sprintf('Error detected on %s sheet, cell A%s : The identifier has been duplicated.', $this->sheetName, $this->rowCount);

            return true;
        }

        if ($validate) {
            if (!is_null($type)) {
                $element = $type;
            }

            if (!Arr::get($this->identifiers, "$element.$elementIdentifier", false)) {
                $this->tempErrors["$element > $this->rowCount"] = sprintf('Error detected on %s sheet, cell A%s : The identifier does not have correct format.', $this->sheetName, $this->rowCount);

                return true;
            }
        }

        $this->trackIdentifierBySheet[$this->sheetName][] = $elementIdentifier;

        return false;
    }
}
