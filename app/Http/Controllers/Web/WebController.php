<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

/**
 * Class WebController.
 */
class WebController extends Controller
{
    /**
     * Shows the web page.
     *
     * @param string $page
     * @return Renderable
     */
    public function index(string $page = 'signin'): Renderable
    {
        try {
            [$message, $intent] = $this->updateMessageIntent();

            return view('web.welcome', compact('page', 'intent', 'message'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
        }
    }

    /**
     * Check and update message for user redirection to login page.
     *
     * @return array
     */
    private function updateMessageIntent(): array
    {
        $message = '';
        $intent = '';

        if (Str::contains(Redirect::intended()->getTargetUrl(), '/email/verify/')) {
            $message = 'User must be logged in to verify email.';
            $intent = 'verify';
        }

        return [$message, $intent];
    }

    /**
     * Shows the web page.
     *
     * @return Renderable
     */
    public function register(): Renderable
    {
        return view('web.register');
    }

    /**
     * Shows the about page.
     *
     * @return Renderable
     */
    public function about(): Renderable
    {
        return view('web.about');
    }

    /**
     * Shows the publisher checklist page.
     *
     * @return Renderable
     */
    public function publishingChecklist(): Renderable
    {
        return view('web.publishing_checklist');
    }

    /**
     * Shows the iati standard checklist page.
     *
     * @return Renderable
     */
    public function iatiStandard(): Renderable
    {
        return view('web.iati_standard');
    }

    /**
     * Shows the support checklist page.
     *
     * @return Renderable
     */
    public function support(): Renderable
    {
        return view('web.support');
    }

    /**
     * Updates the locale of the system.
     *
     * @param $language
     *
     * @return JsonResponse
     */
    public function setLocale($language): JsonResponse
    {
        try {
            if (!in_array($language, ['en', 'fr', 'es'])) {
                return response()->json(['success' => false, 'message' => 'Invalid language code.']);
            }

            session()->put('locale', $language);

            return response()->json(['success' => true, 'message' => 'Locale changed successfully.']);
        } catch (\Exception $e) {
            logger()->error($e);

            return response()->json(['success' => false, 'message' => 'Error has occurred when changing locale.']);
        }
    }

    /**
     * Returns the translated data for the given folder.
     *
     * @param $folder
     *
     * @return JsonResponse
     */
    public function getTranslatedData($folder): JsonResponse
    {
        try {
            $lang = App::getLocale();
            $path = base_path("lang/{$lang}/{$folder}");

            if (!File::isDirectory($path) && $folder !== 'general') {
                return response()->json(['success' => false, 'message' => 'Directory not found.']);
            }

            $cacheData = Cache::get("translated_data_{$lang}");

            if ($cacheData) {
                return response()->json(['success' => true, 'data' => Arr::get($cacheData, $folder, [])]);
            }

            $folders = File::directories(base_path("lang/{$lang}"));

            foreach ($folders as $fl) {
                $folderName = basename($fl);
                $files = File::allFiles($fl);
                $translations = [];

                foreach ($files as $file) {
                    $fileName = pathinfo($file->getRealPath(), PATHINFO_FILENAME);
                    $fileTranslations = require $file->getRealPath();
                    $translations[$fileName] = $fileTranslations;
                }

                $cacheData[$folderName] = $translations;
            }

            $outerFiles = File::allFiles(base_path("lang/{$lang}"));
            $outerFiletranslations = [];

            foreach ($outerFiles as $outerFile) {
                $outerFileName = pathinfo($outerFile->getRealPath(), PATHINFO_FILENAME);
                $obtainedData = require $outerFile->getRealPath();
                $outerFiletranslations[$outerFileName] = $obtainedData;
            }

            $cacheData['general'] = $outerFiletranslations;

            Cache::put("translated_data_{$lang}", $cacheData, now()->addHours(24));

            if ($folder !== 'general') {
                return response()->json(['success' => true, 'data' => $translations]);
            }

            return response()->json(['success' => true, 'data' => $outerFiletranslations]);
        } catch (\Exception $e) {
            logger()->error($e);

            return response()->json(['success' => false, 'message' => 'Error has occurred when returning translated data.']);
        }
    }
}
