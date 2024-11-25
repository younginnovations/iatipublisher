<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\Transaction\TransactionRequest;
use App\Http\Requests\BulkDeleteTransactionRequest;
use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\Activity\TransactionService;
use App\IATI\Traits\EditFormTrait;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

/**
 * TransactionController Class.
 */
class TransactionController extends Controller
{
    use EditFormTrait;

    /**
     * @var BaseFormCreator
     */
    protected BaseFormCreator $baseFormCreator;

    /**
     * @var TransactionService
     */
    protected TransactionService $transactionService;

    /**
     * @var ActivityService
     */
    protected ActivityService $activityService;

    /**
     * TransactionController Constructor.
     *
     * @param BaseFormCreator    $baseFormCreator
     * @param TransactionService $transactionService
     * @param ActivityService    $activityService
     */
    public function __construct(
        BaseFormCreator $baseFormCreator,
        TransactionService $transactionService,
        ActivityService $activityService
    ) {
        $this->baseFormCreator = $baseFormCreator;
        $this->transactionService = $transactionService;
        $this->activityService = $activityService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param $activityId
     *
     * @return Factory|View|RedirectResponse|Application
     */
    public function index($activityId): Factory|View|RedirectResponse|Application
    {
        try {
            $activity = $this->activityService->getActivity($activityId);
            $transactions = $this->transactionService->getActivityTransactions($activityId);
            $types = getTransactionTypes();
            $toast = generateToastData();

            return view('admin.activity.transaction.transaction', compact('activity', 'transactions', 'types', 'toast'));
        } catch (Exception $e) {
            logger()->error($e);

            return redirect()->route('admin.activity.show', $activityId)->with(
                'error',
                'Error has occurred while rendering activity transactions listing.'
            );
        }
    }

    /**
     * Returns paginated transactions.
     *
     * @param int $activityId
     * @param int $page
     *
     * @return JsonResponse
     */
    public function getPaginatedTransactions(int $activityId, int $page = 1): JsonResponse
    {
        try {
            $transaction = $this->transactionService->getPaginatedTransactionAndStats($activityId, $page, $this->sanitizeRequest(request()));
            $stats = $this->transactionService->getTransactionCountStats($activityId);

            return response()->json([
                'success' => true,
                'message' => 'Transactions fetched successfully',
                'data'    => [
                    'transactions' => $transaction,
                    'stats'        => $stats,
                ],
            ]);
        } catch (Exception $e) {
            logger()->error($e);

            return response()->json(['success' => false, 'message' => 'Error occurred while fetching the data']);
        }
    }

    public function sanitizeRequest(\Illuminate\Http\Request $request): array
    {
        $tableConfig = getTableConfig('transaction');
        $transactionTypeMap = [
            'all'                 => 'all',
            'incoming_funds'      => 1,
            'outgoing_commitment' => 2,
            'disbursement'        => 3,
            'expenditure'         => 4,
            'others'              => 'others',
        ];

        $queryParams = [];

        if (!empty($request->get('q')) || $request->get('q') === '0') {
            $queryParams['query'] = $request->get('q');
        }

        if (!empty($request->get('limit'))) {
            $queryParams['limit'] = $request->get('limit') ?? 10;
        }

        if (in_array($request->get('orderBy'), $tableConfig['orderBy'], true)) {
            $queryParams['orderBy'] = $request->get('orderBy') ?? '';

            if (in_array($request->get('direction'), $tableConfig['direction'], true)) {
                $queryParams['direction'] = $request->get('direction') ?? 'asc';
            }
        }

        if (in_array($request->get('filterBy'), $tableConfig['filterBy'], true)) {
            $queryParams['filterBy'] = $request->get('filterBy');
            $queryParams['filterBy'] = Arr::get($transactionTypeMap, $queryParams['filterBy'], 'all');
        }

        return $queryParams;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $activityId
     *
     * @return Factory|View|RedirectResponse|Application
     */
    public function create($activityId): Factory|View|RedirectResponse|Application
    {
        try {
            $activity = $this->activityService->getActivity($activityId);
            $element = $this->transactionService->getManipulatedTransactionElementSchema($activity);
            $form = $this->transactionService->createFormGenerator(
                activityId                : $activityId,
                element                   : $element,
                activityDefaultFieldValues: $activity->default_field_values ?? []
            );

            $formHeader = $this->getFormHeader(
                hasData    : false,
                elementName: 'transaction',
                parentTitle: Arr::get($activity, 'title.0.narrative', 'Untitled')
            );
            $breadCrumbInfo = $this->transactionBreadCrumbInfo(
                activity   : $activity,
                transaction: null
            );

            $data = ['title'            => $element['label'],
                     'name'             => 'transactions',
                     'form_header'      => $formHeader,
                     'bread_crumb_info' => $breadCrumbInfo,
            ];

            return view('admin.activity.transaction.edit', compact('form', 'activity', 'data'));
        } catch (Exception $e) {
            logger()->error($e);

            return redirect()->route('admin.activity.show', $activityId)->with(
                'error',
                'Error has occurred while rendering activity transaction form.'
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TransactionRequest $request
     * @param                    $activityId
     *
     * @return RedirectResponse
     */
    public function store(TransactionRequest $request, $activityId): RedirectResponse
    {
        try {
            $transactionData = $request->except('_token');
            $transaction = $this->transactionService->create([
                'activity_id' => $activityId,
                'transaction' => $transactionData,
            ]);

            return redirect()->route('admin.activity.transaction.show', [$activityId, $transaction['id']])->with(
                'success',
                'Activity transaction created successfully.'
            );
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.transaction.index', $activityId)->with(
                'error',
                'Error has occurred while creating activity transaction.'
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $activityId
     * @param $transactionId
     *
     * @return Factory|View|RedirectResponse|Application
     */
    public function show($activityId, $transactionId): Factory|View|RedirectResponse|Application
    {
        try {
            $activity = $this->activityService->getActivity($activityId);
            $transaction = $this->transactionService->getTransaction($transactionId);
            $element = getElementSchema('transactions');
            $types = getTransactionTypes();
            $toast = generateToastData();

            return view('admin.activity.transaction.detail', compact('transaction', 'activity', 'types', 'toast', 'element'));
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.transaction.index', $activityId)->with(
                'error',
                'Error has occurred while rending transaction detail page.'
            );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $activityId
     * @param $transactionId
     *
     * @return Factory|View|RedirectResponse|Application
     */
    public function edit($activityId, $transactionId): Factory|View|RedirectResponse|Application
    {
        try {
            $activity = $this->activityService->getActivity($activityId);
            $element = $this->transactionService->getManipulatedTransactionElementSchema($activity, $transactionId);
            $form = $this->transactionService->editFormGenerator($transactionId, $activityId, $element);

            $formHeader = $this->getFormHeader(
                hasData    : false,
                elementName: 'transaction',
                parentTitle: Arr::get($activity, 'title.0.narrative', 'Untitled')
            );
            $breadCrumbInfo = $this->transactionBreadCrumbInfo(
                activity   : $activity,
                transaction: null
            );

            $data = ['title'            => $element['label'],
                     'name'             => 'transactions',
                     'form_header'      => $formHeader,
                     'bread_crumb_info' => $breadCrumbInfo,
            ];

            return view('admin.activity.transaction.edit', compact('form', 'activity', 'data'));
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.transaction.index', $activityId)->with(
                'error',
                'Error has occurred while rendering activity transaction form.'
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TransactionRequest $request
     * @param                    $activityId
     * @param                    $transactionId
     *
     * @return RedirectResponse
     */
    public function update(TransactionRequest $request, $activityId, $transactionId): RedirectResponse
    {
        try {
            if (!$this->transactionService->update($transactionId, $request->except(['_method', '_token']))) {
                return redirect()->route('admin.activity.transaction.index', $activityId)->with(
                    'error',
                    'Error has occurred while updating activity transaction.'
                );
            }

            return redirect()->route('admin.activity.transaction.show', [$activityId, $transactionId])->with(
                'success',
                'Activity transaction updated successfully.'
            );
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity.transaction.index', $activityId)->with(
                'error',
                'Error has occurred while updating activity transaction.'
            );
        }
    }

    /**
     * Deletes Specific Transaction.
     *
     * @param $id
     * @param $transactionId
     *
     * @return JsonResponse
     */
    public function destroy($id, $transactionId): JsonResponse
    {
        try {
            $this->transactionService->deleteTransaction($transactionId);

            Session::flash('success', 'Transaction Deleted Successfully');

            return response()->json([
                'status'      => true,
                'msg'         => 'Transaction Deleted Successfully',
                'activity_id' => $id,
            ]);
        } catch (Exception $e) {
            logger()->error($e->getMessage());
            Session::flash('error', 'Transaction Delete Error');

            return response()->json([
                'status'      => false,
                'msg'         => 'Transaction Delete Error',
                'activity_id' => $id,
            ], 400);
        }
    }

    /**
     * Bulk deletes transactions.
     *
     * @param BulkDeleteTransactionRequest $request
     * @param                                                 $id
     *
     * @return JsonResponse
     */
    public function bulkDeleteTransactions(BulkDeleteTransactionRequest $request, $id): JsonResponse
    {
        try {
            $transactionIds = $request->validated('transaction_ids');

            DB::beginTransaction();
            $this->transactionService->bulkDeleteTransactions($transactionIds);
            DB::commit();

            return response()->json([
                'status'      => true,
                'msg'         => 'Transactions Deleted Successfully',
                'activity_id' => $id,
            ], 200);
        } catch (Exception $e) {
            DB::rollback();
            logger()->error($e);

            return response()->json([
                'status'      => false,
                'msg'         => 'Failed to bulk delete transactions.',
                'activity_id' => $id,
            ], 400);
        }
    }
}
