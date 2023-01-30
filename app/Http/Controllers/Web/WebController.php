<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
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
     * Returns csv file import template.
     *
     * @param string $type
     * @return BinaryFileResponse|JsonResponse
     */
    public function downloadIatiStandardManual(string $type): BinaryFileResponse|JsonResponse
    {
        try {
            $headers = [
                'Content-Type' => 'application/pdf',
            ];

            if ($type === 'organization') {
                $headers['Content-Disposition'] = 'attachment; filename=IATI Publisher - Organisation Standard.pdf';

                return response()->file(app_path('Data/Manuals/IATI_Publisher_Organisation_Standard.pdf'), $headers);
            }

            if ($type === 'activity') {
                $headers['Content-Disposition'] = 'attachment; filename=IATI Publisher - Activity Standard.pdf';

                return response()->file(app_path('Data/Manuals/IATI_Publisher_Activity_Standard.pdf'), $headers);
            }

            if ($type === 'user') {
                $headers['Content-Disposition'] = 'attachment; filename=IATI Publisher - User Manual v1.0.pdf';

                return response()->file(app_path('Data/Manuals/IATI_Publisher-User_Manual_v1.0.pdf'), $headers);
            }

            return response()->json(['success' => false, 'message' =>'File couldn\'t be found.']);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
