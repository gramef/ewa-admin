<?php
/*
 * File name: EProviderPayoutController.php
 * Last modified: 2021.03.25 at 16:41:38
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

namespace App\Http\Controllers;

use App\Criteria\EProviderPayouts\EProviderPayoutsOfUserCriteria;
use App\Criteria\EProviders\EProvidersOfUserCriteria;
use App\Criteria\Users\UserOfEProviderCriteria;
use App\DataTables\EProviderPayoutDataTable;
use App\Http\Requests\CreateEProviderPayoutRequest;
use App\Http\Requests\UpdateEProviderPayoutRequest;
use App\Models\User;
use App\Notifications\EProviderPayoutPaid;
use App\Notifications\NewEProviderPayout;
use App\Repositories\CustomFieldRepository;
use App\Repositories\EarningRepository;
use App\Repositories\EProviderPayoutRepository;
use App\Repositories\EProviderRepository;
use Carbon\Carbon;
use Flash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Exceptions\ValidatorException;

class EProviderPayoutController extends Controller
{
    /** @var  EProviderPayoutRepository */
    private $eProviderPayoutRepository;

    /**
     * @var CustomFieldRepository
     */
    private $customFieldRepository;

    /**
     * @var EProviderRepository
     */
    private $eProviderRepository;
    /**
     * @var EarningRepository
     */
    private $earningRepository;

    public function __construct(EProviderPayoutRepository $eProviderPayoutRepo, CustomFieldRepository $customFieldRepo, EProviderRepository $eProviderRepo, EarningRepository $earningRepository)
    {
        parent::__construct();
        $this->eProviderPayoutRepository = $eProviderPayoutRepo;
        $this->customFieldRepository = $customFieldRepo;
        $this->eProviderRepository = $eProviderRepo;
        $this->earningRepository = $earningRepository;
    }

    /**
     * Display a listing of the EProviderPayout.
     *
     * @param EProviderPayoutDataTable $eProviderPayoutDataTable
     */
    public function index(EProviderPayoutDataTable $eProviderPayoutDataTable)
    {
        return $eProviderPayoutDataTable->render('e_provider_payouts.index');
    }

    /**
     * Show the form for creating a new EProviderPayout.
     *
     * @param int $id
     * @return Application|Factory|Response|View
     * @throws RepositoryException
     */
    public function create()
    {
        $this->eProviderRepository->pushCriteria(new EProvidersOfUserCriteria(auth()->id()));
        $eProviderPayoutFile = null;
        $eProvider = $this->eProviderRepository->all()->pluck('name', 'id');
        if (empty($eProvider)) {
            Flash::error(__('lang.not_found', ['operator' => __('lang.e_provider')]));
            return redirect(route('eProviderPayouts.index'));
        }
        $hasCustomField = in_array($this->eProviderPayoutRepository->model(), setting('custom_field_models', []));
        if ($hasCustomField) {
            $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->eProviderPayoutRepository->model());
            $html = generateCustomField($customFields);
        }
        return view('e_provider_payouts.create')->with("customFields", isset($html) ? $html : false)->with("eProvider", $eProvider)->with("eProviderPayoutFile", $eProviderPayoutFile);
    }

    /**
     * Show the form for editing the specified EProviderPayout.
     *
     * @param int $id
     * @return Application|Factory|Response|View
     * @throws RepositoryException
     */
    public function edit(int $id)
    {
        $eProviderPayout = $this->eProviderPayoutRepository->findWithoutFail($id);
        if (empty($eProviderPayout)) {
            Flash::error(__('lang.not_found', ['operator' => __('lang.e_provider_payout')]));
            return redirect(route('eProviderPayouts.index'));
        }
        $this->eProviderRepository->pushCriteria(new EProvidersOfUserCriteria(auth()->id()));
        $eProvider = $this->eProviderRepository->findWithoutFail($eProviderPayout->e_provider_id);
        if (empty($eProvider)) {
            Flash::error(__('lang.not_found', ['operator' => __('lang.e_provider')]));
            return redirect(route('eProviderPayouts.index'));
        }
        $eProviderPayoutFile = $eProviderPayout->receipt_pdf;
        $hasCustomField = in_array($this->eProviderPayoutRepository->model(), setting('custom_field_models', []));
        if ($hasCustomField) {
            $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->eProviderPayoutRepository->model());
            $html = generateCustomField($customFields, $eProviderPayout);
        }
        return view('e_provider_payouts.edit')->with("customFields", isset($html) ? $html : false)->with("eProviderPayout", $eProviderPayout)->with("eProvider", $eProvider)->with("eProviderPayoutFile", $eProviderPayoutFile);;
    }

    /**
     * Update the specified EProviderPayout in storage.
     *
     * @param int $id
     * @param UpdateEProviderPayoutRequest $request
     * @return Application|RedirectResponse|Redirector|Response
     */
    public function update(int $id, UpdateEProviderPayoutRequest $request)
    {
        $input = $request->all();
        $eProviderPayout = $this->eProviderPayoutRepository->findWithoutFail($id);
        $eProvider = $this->eProviderRepository->findWithoutFail($input['e_provider_id']);
        $user = $this->eProviderPayoutRepository->pushCriteria(new UserOfEProviderCriteria($eProvider));
        if (empty($eProviderPayout)) {
            Flash::error(__('lang.not_found', ['operator' => __('lang.e_provider_payout')]));
            return redirect(route('eProviderPayouts.index'));
        }



        // Handle file upload
        if ($request->hasFile('receipt_pdf')) {
            $file = $request->file('receipt_pdf');
            $path = $file->store('receipts', 'public');
            $input['receipt_pdf'] = $path;
            Notification::send($user, new EProviderPayoutPaid($eProvider,$eProviderPayout));
        }

        // Update the record
        try {
            $eProviderPayout = $this->eProviderPayoutRepository->update($input, $id);
            $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->eProviderPayoutRepository->model());
            $eProviderPayout->customFieldsValues()->delete(); // Remove old custom fields values
            $eProviderPayout->customFieldsValues()->createMany(getCustomFieldsValues($customFields, $request));
            Flash::success(__('lang.updated_successfully', ['operator' => __('lang.e_provider_payout')]));
        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        return redirect(route('eProviderPayouts.index'));
    }

    /**
     * Store a newly created EProviderPayout in storage.
     *
     * @param CreateEProviderPayoutRequest $request
     *
     * @return Application|RedirectResponse|Redirector|Response
     */
    public function store(CreateEProviderPayoutRequest $request)
    {
        $input = $request->all();
        if ($input['amount'] <= 0) {
            Flash::error(__('lang.not_found', ['operator' => __('lang.earning')]));
            return redirect(route('eProviderPayouts.index'));
        }
        $totalEarnings = $this->earningRepository->findByField("e_provider_id", $input['e_provider_id'])->get("e_provider_earning");
        //Log::info($totalEarnings);
        if ($input['amount'] > $totalEarnings) {
            Flash::error(__('lang.amount_exceeds_earnings'));
            return redirect(route('eProviderPayouts.index'));
        }
        $input['paid_date'] = Carbon::now();
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->eProviderPayoutRepository->model());
        $admin = User::role('admin')->first();

        try {
            $eProviderPayout = $this->eProviderPayoutRepository->create($input);
            $eProviderPayout->customFieldsValues()->createMany(getCustomFieldsValues($customFields, $request));
            $eProvider = $this->eProviderRepository->findWithoutFail($eProviderPayout->e_provider_id);
            //Log::info($eProvider);
            Notification::send($admin, new NewEProviderPayout($eProvider, $eProviderPayout));

        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }


        Flash::success(__('lang.saved_successfully', ['operator' => __('lang.e_provider_payout')]));

        return redirect(route('eProviderPayouts.index'));
    }

    /**
     * Remove the specified EProviderPayout from storage.
     *
     * @param int $id
     * @return Application|RedirectResponse|Redirector|Response
     */
    public function destroy(int $id)
    {
        $eProviderPayout = $this->eProviderPayoutRepository->findWithoutFail($id);
        if (empty($eProviderPayout)) {
            Flash::error(__('lang.not_found', ['operator' => __('lang.e_provider_payout')]));
            return redirect(route('eProviderPayouts.index'));
        }

        $this->eProviderPayoutRepository->delete($id);

        Flash::success(__('lang.deleted_successfully', ['operator' => __('lang.e_provider_payout')]));

        return redirect(route('eProviderPayouts.index'));
    }
}
