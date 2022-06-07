<?php

declare(strict_types=1);

if (!function_exists('getCodeList')) {
    /**
     * return codeList array from json codeList.
     *
     * @param      $listName
     * @param      $listType
     * @param bool $code
     *
     * @return array
     */
    function getCodeList($listName, $listType, bool $code = true): array
    {
        $filePath = app_path("Data/$listType/$listName.json");
        $codeListFromFile = file_get_contents($filePath);
        $codeLists = json_decode($codeListFromFile, true);
        $codeList = $codeLists[$listName];
        $data = [];

        foreach ($codeList as $list) {
            $data[$list['code']] = ($code) ? $list['code'] . (array_key_exists('name', $list) ? ' - ' . $list['name'] : '') : $list['name'];
        }

        return $data;
    }

    /**
     * return codeList array from codeList.
     *
     * @param      $listName
     * @param      $listType
     * @param bool $code
     *
     * @return array
     */
    function getCodeListArray($listName, $listType, bool $code = true): array
    {
        $filePath = app_path("Data/$listType/$listName.php");
        $codeListFromFile = include $filePath;
        $data = [];

        foreach ($codeListFromFile as $key => $value) {
            $data[$key] = ($code) ? $key . ' - ' . $value : $value;
        }

        return $data;
    }
}

if (!function_exists('getList')) {
    /**
     * Return codeList array from json codeList.
     * @param string $filePath
     * @param bool $code
     * @return array
     */
    function getList(string $filePath, bool $code = true): array
    {
        $filePath = app_path("Data/$filePath");
        $codeListFromFile = file_get_contents($filePath);
        $codeLists = json_decode($codeListFromFile, true);
        $codeList = last($codeLists);
        $data = [];

        foreach ($codeList as $list) {
            $data[$list['code']] = ($code) ? $list['code'] . (array_key_exists(
                'name',
                $list
            ) ? ' - ' . $list['name'] : '') : $list['name'];
        }

        return $data;
    }
}
