<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Arr;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class GeneralController.
 */
class GeneralController extends Controller
{
    /**
     * Extracts mimetype of file or url.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getFileExtension(Request $request): JsonResponse
    {
        try {
            $fileUrl = $request->query('url');
            $type = $request->query('type');
            $mimeType = '';

            if (empty($fileUrl)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please enter file url to get mimetype.',
                    'data' => [
                        'mimetype' => $mimeType,
                        'type' => $type,
                        'url' => $fileUrl,
                        'validity' => filter_var($fileUrl, FILTER_VALIDATE_URL),
                    ],
                ]);
            }

            $fileFormat = getCodeList('FileFormat', 'Activity');
            $extensions = array_flip(json_decode(file_get_contents(app_path('Data/Activity/Extension.json')), true, 512, JSON_THROW_ON_ERROR));
            $additionalExtensions = json_decode(file_get_contents(app_path('Data/Activity/AdditionalExtension.json')), true, 512, JSON_THROW_ON_ERROR);
            $fileFragment = $type === 'url' ? Arr::get(parse_url($fileUrl), 'path', null) : $fileUrl;
            $fileExtension = $fileFragment ? pathinfo($fileFragment, PATHINFO_EXTENSION) : null;

            if (!empty($fileExtension) && (Arr::get($extensions, $fileExtension, false) || Arr::get($additionalExtensions, $fileExtension, false))) {
                $mimeType = isset($extensions[$fileExtension]) ? Arr::get($extensions, $fileExtension, '') : Arr::get($additionalExtensions, $fileExtension, '');
            } elseif (str_starts_with($fileUrl, url('/'))) {
                $mimeType = 'text/html';
            } elseif (filter_var($fileUrl, FILTER_VALIDATE_URL)) {
                $fileUrl = filter_var($fileUrl, FILTER_VALIDATE_URL);
                $ch = curl_init($fileUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HEADER, true);
                curl_exec($ch);
                $curlInfo = curl_getinfo($ch);
                $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                if (!($statusCode >= 400 && $statusCode <= 500)) {
                    $mimeType = 'text/html';

                    if ($curlInfo['content_type']) {
                        $mimeType = explode(';', $curlInfo['content_type'])[0];
                    }
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Please ensure that url is correct and is publicly accessible.',
                        'data' => [
                            'mimetype' => $mimeType,
                        ],
                    ]);
                }
            }

            if (!array_key_exists($mimeType, $fileFormat)) {
                $mimeType = '';
            }

            return response()->json([
                'success' => true,
                'message' => 'Mimetype fetched successfully',
                'data' => [
                    'mimetype' => $mimeType,
                ],
            ]);
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while mapping the file extension']);
        }
    }
}
