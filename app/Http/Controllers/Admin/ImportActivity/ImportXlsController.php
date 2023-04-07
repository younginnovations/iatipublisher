<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\ImportActivity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\UploadActivity\ImportXlsRequest;
use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\ImportActivity\ImportXlsService;
use App\IATI\Services\ImportActivityError\ImportActivityErrorService;
use App\XlsImporter\Foundation\Mapper\Activity;
use App\XlsImporter\Foundation\Mapper\Indicator;
use App\XlsImporter\Foundation\Mapper\Period;
use Arr;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

/**
 * Class ActivityController.
 */
class ImportXlsController extends Controller
{
    /**
     * @var ActivityService
     */
    protected ActivityService $activityService;

    /**
     * @var ImportXlsService
     */
    protected ImportXlsService $importXlsService;

    /**
     * @var ImportActivityErrorService
     */
    protected ImportActivityErrorService $importActivityErrorService;

    /**
     * @var DatabaseManager
     */
    protected DatabaseManager $db;

    /**
     * @var string
     */
    public string $xls_data_storage_path;

    /**
     * ActivityController Constructor.
     *
     * @param ActivityService  $activityService
     * @param ImportXlsService $importXlsService
     * @param ImportActivityErrorService $importActivityErrorService
     * @param DatabaseManager  $db
     */
    public function __construct(ActivityService $activityService, ImportXlsService $importXlsService, ImportActivityErrorService $importActivityErrorService, DatabaseManager $db)
    {
        $this->activityService = $activityService;
        $this->importXlsService = $importXlsService;
        $this->importActivityErrorService = $importActivityErrorService;
        $this->db = $db;
        $this->xls_data_storage_path = env('XLS_DATA_STORAGE_PATH', 'XlsImporter/tmp');
    }

    /**
     * Display a listing of the resource.
     *
     * @return View|JsonResponse|RedirectResponse
     */
    public function index(): View|JsonResponse|RedirectResponse
    {
        try {
            $elements = readElementJsonSchema();
            // $final = [];

            // foreach ($elements as $elementName => $content) {
            //     $attributes = $this->getAttributes(Arr::get($content, 'attributes', []));
            //     $subElements = $this->getSubElements(Arr::get($content, 'sub_elements', []));

            //     foreach ($subElements as $key => $value) {
            //         $attributes[$key] = $value;
            //     }

            //     $final[$elementName] = $attributes;
            // }

            // dd(json_encode($final));

            // $this->getLinearizedElement();

            // $data = getCodeList('FileFormat', 'Activity', false);
            // $data = json_encode(getCodeList('Region', 'Activity'));
            // test
            // $data = file_get_contents(app_path() . '/XlsImporter/Templates/test.json');
            // $activityMapper = new Activity();
            // $activityMapper->map($data);

            // period

            $data = file_get_contents(app_path() . '/XlsImporter/Templates/period.json');
            $periodMapper = new Period();
            $periodMapper->map($data);

            // indicator
            // $data = file_get_contents(app_path() . '/XlsImporter/Templates/indicator.json');
            // $indicatorMapper = new Indicator();
            // $indicatorMapper->map($data);
            dd('stop');
            //            $resultData = file_get_contents(app_path('/XlsImporter/Templates/result.json'));
//                       $resultMapper = new Result();
//                       $resultMapper->map($resultData);

            //            $data = file_get_contents(app_path() . '/XlsImporter/Templates/period.json');
//            $periodMapper = new Period();
//            $periodMapper->map($data);

            // $periodMapper

            //            $resultData = file_get_contents(app_path('/XlsImporter/Templates/result.json'));
//            $resultMapper = new Result();
//            $resultMapper->map($resultData);

            if (!Auth::user()->organization_id) {
                Session::put('error', 'User is not associated with any organization.');

                return redirect()->route('admin.activities.index');
            }

            return view('admin.import.xls.index');
        } catch (Exception $e) {
            dd($e);
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'error' => 'Error has occurred while rendering activity import page.']);
        }
    }

    public function getAttributes($attributes, $parentName = '', $parentLabel = '')
    {
        $attributeMapper = [];

        foreach ($attributes as $attributeName => $attributeContent) {
            // if (isset($attributeContent[$attributeName]['type']) && $attributeContent[$attributeName]['type'] === 'select') {
            //     $attributeMapper[(!empty($parentName) ? $parentName . ' ' : '') . $attributeName] = $attributeContent[$attributeName]['choices'];
            // }
            $attributeMapper[(!empty($parentName) ? $parentName . ' ' : '') . $attributeName] = (!empty($parentLabel) ? $parentLabel . ' ' : '') . Arr::get($attributeContent, 'label', $attributeName);
        }

        return $attributeMapper;
    }

    public function getSubElements($subElements)
    {
        $mappedSubElements = [];

        foreach ($subElements as $name => $content) {
            $label = Arr::get($content, 'label', $name);
            $attribute = $this->getAttributes(Arr::get($content, 'attributes', []), $name, $label);

            // for generation of select field
            // $fileName = '';
            // if(isset($content['type']) && $content['type'] === 'select'){
            //     $fileName  = $content['choices'];
            // }

            // if ($name === 'narrative') {
            //     $subElement = [
            //         'narrative' => 'Narrative',
            //         'language' => 'Language',
            //     ];
            // } else {
            //     $subElement = $this->getSubElements(Arr::get($content, 'sub_elements', []));
            // }

            // foreach ($attribute as $key => $value) {
            //     $mappedSubElements[$key] = $value;
            // }

            // foreach ($subElement as $key => $subElementValue) {
            //     if (is_array($subElementValue)) {
            //         foreach ($subElementValue as $k => $v) {
            //             if (isset($content[$key][$k]['type']) && $content[$key][$k]['type'] === 'select') {
            //                 $mappedSubElements[($name . ' ') . $k] = $content[$key][$k]['choices'];
            //             } else {
            //                 $mappedSubElements[($name . ' ') . $k] = $label . '_' . $v;
            //             }
            //             // $mappedSubElements[($name . ' ') . $k] = $label . '_' . $v;
            //             // }
            //         }
            //     } else {
            //         if (isset($content[$key]['type']) && $content[$key]['type'] === 'select') {
            //             $mappedSubElements[($name . ' ') . $key] = $content[$key]['choices'];
            //         } else {
            //             $mappedSubElements[($name . ' ') . $key] = $label . '_' . $key;
            //         }
            //         // if (!empty($fileName)) {
            //         // }
            //     }
            // }

            // to generate column name in correspondence to parent.. equivalent to one used in excel file
            if ($name === 'narrative') {
                $subElement = [
                    'narrative' => 'Narrative',
                    'language' => 'Language',
                ];
            } else {
                $subElement = $this->getSubElements(Arr::get($content, 'sub_elements', []));
            }

            foreach ($attribute as $key => $value) {
                $mappedSubElements[$key] = str_replace('-', '_', str_replace(' ', '_', $value));
            }

            foreach ($subElement as $key => $subElementValue) {
                if (is_array($subElementValue)) {
                    foreach ($subElementValue as $k => $v) {
                        $mappedSubElements[($name . ' ') . $k] = str_replace('-', '_', str_replace(' ', '_', $label . '_' . $v));
                    }
                } else {
                    $mappedSubElements[($name . ' ') . $key] = str_replace('-', '_', str_replace(' ', '_', $label . '_' . $key));
                }
            }
        }

        return $mappedSubElements;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ImportXlsRequest $request
     *
     * @return JsonResponse
     */
    public function store(ImportXlsRequest $request): JsonResponse
    {
        try {
            $file = $request->file('activity');
            $filetype = 'activity';
            Session::put('import_filetype', $filetype);

            if ($this->importXlsService->store($file)) {
                $user = Auth::user();
                $this->importXlsService->startImport($file->getClientOriginalName(), $user->id, $user->organization_id);
            }

            return response()->json(['success' => true, 'message' => 'Uploaded successfully', 'type' => $filetype]);
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'error' => 'Error has occurred while rendering activity import page.']);
        }
    }

    /**
     * Import validated activities into the database.
     *
     * @param Request $request
     *
     * @return mixed
     * @throws \Throwable
     */
    public function importValidatedActivities(Request $request): mixed
    {
        try {
            $this->db->beginTransaction();
            $activities = $request->get('activities');
            $filetype = Session::get('import_filetype');

            if ($activities) {
                if ($filetype === 'xml') {
                    $this->importXlsService->create($activities);
                } else {
                    $this->importXlsService->create($activities);
                    $this->importXlsService->endImport();
                }
            }

            $this->db->commit();

            Session::forget('import_filetype');
            Session::forget('error');
            Session::put('success', 'Imported data successfully.');

            return response()->json(['success' => true, 'message' => 'Imported successfully', 'type' => $filetype]);
        } catch (Exception $e) {
            Session::put('error', 'Error occurred while importing activity');
            logger()->error($e->getMessage());

            return redirect()->back()->withResponse(['success' => false, 'message' => 'Error has occurred while importing activity.']);
        }
    }

    /**
     * Show the status page for the Csv Import process.
     *
     * @return Factory|\Illuminate\View\View
     */
    public function status(): View|RedirectResponse
    {
        try {
            $filetype = Session::get('import_filetype');
            $orgId = Auth::user()->organization_id;
            $userId = Auth::user()->id;

            if (!$orgId) {
                Session::put('error', 'User is not associated with any organization.');

                return redirect()->route('admin.activities.index');
            }

            if (!$filetype) {
                return redirect()->route('admin.activities.index');
            }

            $status = awsGetFile(sprintf('%s/%s/%s/%s', $this->xls_data_storage_path, $orgId, $userId, 'status.json'));
            $schema_error = awsGetFile(sprintf('%s/%s/%s/%s', $this->xls_data_storage_path, $orgId, $userId, 'schema_error.log'));

            if (!$status) {
                Session::put('error', 'status.json file not present in AWS');

                return redirect()->route('admin.activities.index');
            }

            $status = json_decode($status, true, 512, JSON_THROW_ON_ERROR);

            // if ($schema_error) {
            //     Session::put('error', $status['message'] . '. To see errors <b>
            //     <a href=' . awsUrl(sprintf('%s/%s/%s/%s', $this->xls_data_storage_path, $orgId, $userId, 'schema_error.log')) . ' target="_blank">Open Error File</a></b>');

            //     return redirect()->route('admin.activities.index');
            // }

            if (!$status['success']) {
                Session::put('error', $status['message']);

                return redirect()->route('admin.activities.index');
            }

            return view('admin.import.list');
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.index')->withResponse(['success' => false, 'error' => 'Error has occurred while checking the status.']);
        }
    }

    /**
     * Check Import Status.
     *
     * @return JsonResponse
     */
    public function checkStatus(): JsonResponse
    {
        try {
            $filetype = Session::get('import_filetype');

            if (!$filetype) {
                Session::put('error', 'Please upload xls file to import activity.');

                return response()->json(['status' => 'error', 'message' => 'Please upload xls file to import activity.']);
            }

            $result = $this->importXlsService->getAwsCsvData('status.json');
            $data = $this->importXlsService->getAwsCsvData('valid.json');

            $status = strcasecmp($result->message, 'Complete') === 0;

            if (!$data) {
                Session::put('error', 'Error has occurred while importing activities.');
            }

            return response()->json(['status' => $status, 'data' => $data]);
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Returns csv file import template.
     *
     * @return bool|JsonResponse|string
     */
    public function downloadTemplate(): bool|JsonResponse|string
    {
        try {
            return file_get_contents(app_path(sprintf('CsvImporter/Templates/%s/%s.csv', 'Activity', 'other_fields_transaction')));
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Delete upload error with activityId.
     *
     * @param mixed $activityId
     *
     * @return JsonResponse
     */
    public function deleteImportError($activityId): JsonResponse
    {
        try {
            $this->importActivityErrorService->deleteImportError($activityId);

            return response()->json(['success' => true, 'message' => 'Import error for activity has been successfully deleted.']);
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error has occurred while trying to delete import error.']);
        }
    }
}
