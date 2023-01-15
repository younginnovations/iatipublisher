<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Class WebController.
 */
class WebController extends Controller
{
    /**
     * Shows the web page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($page = 'signin'): \Illuminate\Contracts\Support\Renderable
    {
        try {
            list($message, $intent) = $this->updateMessageIntent();

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function register(): \Illuminate\Contracts\Support\Renderable
    {
        return view('web.register');
    }

    /**
     * Shows the about page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function about(): \Illuminate\Contracts\Support\Renderable
    {
        return view('web.about');
    }

    /**
     * Shows the publisher checklist page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function publishingChecklist(): \Illuminate\Contracts\Support\Renderable
    {
        return view('web.publishing_checklist');
    }

    /**
     * Shows the iati standard checklist page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function iatiStandard(): \Illuminate\Contracts\Support\Renderable
    {
        return view('web.iati_standard');
    }

    /**
     * Shows the support checklist page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function support(): \Illuminate\Contracts\Support\Renderable
    {
        return view('web.support');
    }

    /**
     * Returns csv file import template.
     *
     * @return BinaryFileResponse|JsonResponse
     */
    public function downloadIatiStandardManual(string $type): BinaryFileResponse|JsonResponse
    {
        try {
            if ($type === 'organization') {
                return response()->file(app_path('Data/Manuals/IATI_Publisher_Organisation_Standard.pdf'));
            }

            if ($type === 'activity') {
                return response()->file(app_path('Data/Manuals/IATI_Publisher_Activity_Standard.pdf'));
            }

            return response()->json(['success' => false, 'message' =>'File couldn\'t be found.']);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
