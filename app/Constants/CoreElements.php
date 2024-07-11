<?php

declare(strict_types=1);

namespace App\Constants;

use JsonException;

class CoreElements
{
    /**
     * @throws JsonException
     */
    public static function all(): array
    {
        return array_keys(self::dataFromFile());
    }

    /**
     * @return array
     * @throws JsonException
     */
    public static function getCoreElementsWithTrueValue(): array
    {
        return self::dataFromFile();
    }

    /**
     * @throws JsonException
     */
    private static function dataFromFile()
    {
        return json_decode(file_get_contents(public_path('Data/coreElements.json')), true, 512, JSON_THROW_ON_ERROR);
    }
}
