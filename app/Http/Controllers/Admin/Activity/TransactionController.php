<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\Transaction\TransactionRequest;
use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\Activity\TransactionService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

/**
 * TransactionController Class.
 */
class TransactionController extends Controller
{
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
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

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
            $transaction = $this->transactionService->getPaginatedTransaction($activityId, $page);

            return response()->json([
                'success' => true,
                'message' => 'Transactions fetched successfully',
                'data'    => $transaction,
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while fetching the data']);
        }
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
            $element = getElementSchema('transactions');
            $activity = $this->activityService->getActivity($activityId);
            $form = $this->transactionService->createFormGenerator($activityId);
            $data = ['core' => $element['transactions']['criteria'] ?? false, 'title' => $element['label'], 'name' => 'transactions'];

            return view('admin.activity.transaction.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

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
        } catch (\Exception $e) {
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
            $types = getTransactionTypes();
            $toast = generateToastData();

            return view('admin.activity.transaction.detail', compact('transaction', 'activity', 'types', 'toast'));
        } catch (\Exception $e) {
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
            $element = getElementSchema('transactions');
            $activity = $this->activityService->getActivity($activityId);
            $form = $this->transactionService->editFormGenerator($transactionId, $activityId);
            $data = ['core' => $element['transactions']['criteria'] ?? false, 'title' => $element['label'], 'name' => 'transactions'];

            return view('admin.activity.transaction.edit', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
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
        } catch (\Exception $e) {
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
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            Session::flash('error', 'Transaction Delete Error');

            return response()->json([
                'status'      => false,
                'msg'         => 'Transaction Delete Error',
                'activity_id' => $id,
            ], 400);
        }
    }
}
