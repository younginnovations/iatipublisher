<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Storage;

if (!function_exists('awsHasFile')) {
    /**
     * @param $filePath
     *
     * @return bool
     */
    function awsHasFile($filePath): bool
    {
        return Storage::disk('s3')->exists($filePath);
    }
}

if (!function_exists('awsGetFile')) {
    /**
     * @param $filePath
     *
     * @return string|null
     */
    function awsGetFile($filePath): ?string
    {
        return Storage::disk('s3')->get($filePath);
    }
}

if (!function_exists('awsUploadFile')) {
    /**
     * @param $path
     * @param $content
     *
     * @return bool
     */
    function awsUploadFile($path, $content): bool
    {
        return Storage::disk('s3')->put($path, $content);
    }
}

if (!function_exists('awsUploadFileAs')) {
    /**
     * @param $path
     * @param $content
     * @param $filename
     *
     * @return bool
     */
    function awsUploadFileAs($path, $content, $filename): bool
    {
        return (bool) Storage::disk('s3')->putFileAs($path, $content, $filename);
    }
}

if (!function_exists('awsDeleteFile')) {
    /**
     * @param $filePath
     *
     * @return bool
     */
    function awsDeleteFile($filePath): bool
    {
        if (Storage::disk('s3')->exists($filePath)) {
            return Storage::disk('s3')->delete($filePath);
        }

        return false;
    }
}

if (!function_exists('awsDeleteDirectory')) {
    /**
     * @param $folderName
     *
     * @return bool
     */
    function awsDeleteDirectory($folderName): bool
    {
        if (Storage::disk('s3')->exists($folderName)) {
            return Storage::disk('s3')->deleteDirectory($folderName);
        }

        return false;
    }
}

if (!function_exists('awsUrl')) {
    /**
     * @param $filePath
     *
     * @return string
     */
    function awsUrl($filePath): string
    {
        return Storage::disk('s3')->url($filePath);
    }
}

if (!function_exists('awsFilePath')) {
    /**
     * @param $path
     *
     * @return string
     */
    function awsFilePath($path): string
    {
        return Storage::disk('s3')->path($path);
    }
}

if (!function_exists('localHasFile')) {
    /**
     * @param $filePath
     *
     * @return bool
     */
    function localHasFile($filePath): bool
    {
        return Storage::disk('local')->exists($filePath);
    }
}

if (!function_exists('localUploadFile')) {
    /**
     * @param $path
     * @param $content
     *
     * @return bool
     */
    function localUploadFile($path, $content): bool
    {
        return Storage::disk('local')->put($path, $content);
    }
}

if (!function_exists('localFilePath')) {
    /**
     * @param $path
     *
     * @return string
     */
    function localFilePath($path): string
    {
        return Storage::disk('local')->path($path);
    }
}

if (!function_exists('localDeleteFile')) {
    /**
     * @param $filePath
     *
     * @return bool
     */
    function localDeleteFile($filePath): bool
    {
        if (Storage::disk('local')->exists($filePath)) {
            return Storage::disk('local')->delete($filePath);
        }

        return false;
    }
}

if (!function_exists('getFileNameExtension')) {
    /**
     * Get extension from filename.
     *
     * @param $fileName
     *
     * @return string|null
     */
    function getFileNameExtension($fileName): ?string
    {
        if (empty($fileName)) {
            return null;
        }

        $explodedFileName = explode('.', $fileName);

        return $explodedFileName[1] ?? null;
    }
}
