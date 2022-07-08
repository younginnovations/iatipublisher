<?php

namespace App\Http\Controllers\Admin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\Transaction\TransactionRequest;
use App\IATI\Elements\Builder\BaseFormCreator;
use App\IATI\Elements\Builder\TransactionElementFormCreator;
use App\IATI\Models\Activity\Transaction;
use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\Activity\TransactionService;

class TransactionController extends Controller
{
    /**
     * @var TransactionElementFormCreator
     */
    protected TransactionElementFormCreator $transactionElementFormCreator;

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
     * @param TransactionElementFormCreator $transactionElementFormCreator
     * @param BaseFormCreator $baseFormCreator
     * @param TransactionService $transactionService
     * @param ActivityService $activityService
     */
    public function __construct(
        TransactionElementFormCreator $transactionElementFormCreator,
        BaseFormCreator $baseFormCreator,
        TransactionService $transactionService,
        ActivityService $activityService
    ) {
        $this->baseFormCreator = $baseFormCreator;
        $this->transactionElementFormCreator = $transactionElementFormCreator;
        $this->transactionService = $transactionService;
        $this->activityService = $activityService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $activityId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
     */
    public function create($activityId): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->activityService->getActivity($activityId);
            $this->transactionElementFormCreator->url = route('admin.activities.transactions.store', $activityId);
            $form = $this->transactionElementFormCreator->editForm([], $element['transactions'], 'POST');
            $data = ['core'=> $element['transactions']['criteria'] ?? false, 'status'=> false, 'title'=> $element['transactions']['label'], 'name'=>'transactions'];

            return view('activity.transaction.transaction', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            dd($e);
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $activityId)->with(
                'error',
                'Error has occurred while rendering activity transaction form.'
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TransactionRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TransactionRequest $request, $activityId): \Illuminate\Http\RedirectResponse
    {
        try {
            $transactionData = $request->except('_token');

            if (!$this->transactionService->create([
                    'activity_id' => $activityId,
                    'transaction' => $transactionData,
                ])) {
                return redirect()->route('admin.activities.show', $activityId)->with(
                    'error',
                    'Error has occurred while creating activity transaction.'
                );
            }

            return redirect()->route('admin.activities.show', $activityId)->with(
                'success',
                'Activity transaction created successfully.'
            );
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $activityId)->with(
                'error',
                'Error has occurred while creating activity transaction.'
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\IATI\Models\Activity\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $activityId
     * @param $transactionId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
     */
    public function edit($activityId, $transactionId): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true);
            $activity = $this->activityService->getActivity($activityId);
            $activityTransaction = $this->transactionService->getTransaction($transactionId, $activityId);
            $this->transactionFormCreator->url = route('admin.activities.transactions.update', [$activityId, $transactionId]);
            $form = $this->transactionFormCreator->editForm($activityTransaction->transaction, $element['transactions'], 'PUT');
            $data = ['core'=> $element['transactions']['criteria'] ?? false, 'status'=> false, 'title'=> $element['transactions']['label'], 'name'=>'transactions'];

            return view('activity.transaction.transaction', compact('form', 'activity', 'data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $activityId)->with(
                'error',
                'Error has occurred while rendering activity transaction form.'
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TransactionRequest $request
     * @param $activityId
     * @param $transactionId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TransactionRequest $request, $activityId, $transactionId): \Illuminate\Http\RedirectResponse
    {
        try {
            $transactionData = $request->except(['_method', '_token']);
            $transaction = $this->transactionService->getTransaction($transactionId, $activityId);

            if (!$this->transactionService->update([
                'activity_id'   => $activityId,
                'transaction'   => $transactionData,
            ], $transaction)) {
                return redirect()->route('admin.activities.show', $activityId)->with(
                    'error',
                    'Error has occurred while updating activity transaction.'
                );
            }

            return redirect()->route('admin.activities.show', $activityId)->with(
                'success',
                'Activity transaction updated successfully.'
            );
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.show', $activityId)->with(
                'error',
                'Error has occurred while updating activity transaction.'
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\IATI\Models\Activity\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
