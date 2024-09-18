<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
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
    public function changeLocale($language): JsonResponse
    {
        try {
            if (!in_array($language, ['en', 'fr', 'es'])) {
                return response()->json(['success' => false, 'message' => 'Invalid language code.']);
            }

            App::setLocale($language);

            return response()->json(['success' => true, 'message' => 'Locale changed successfully.']);
        } catch (\Exception $e) {
            logger()->error($e);

            return response()->json(['success' => false, 'message' => 'Error has occurred when changing locale.']);
        }
    }
}
