<?php
/*
 * File name: EServiceReviewController.php
 * Last modified: 2021.03.21 at 21:17:48
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

namespace App\Http\Controllers;

use App\Criteria\EServiceReviews\EServiceReviewsOfUserCriteria;
use App\DataTables\EServiceReviewDataTable;
use App\Http\Requests\CreateEServiceReviewRequest;
use App\Http\Requests\UpdateEServiceReviewRequest;
use App\Repositories\CustomFieldRepository;
use App\Repositories\EServiceRepository;
use App\Repositories\EServiceReviewRepository;
use App\Repositories\UserRepository;
use Exception;
use Flash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Exceptions\ValidatorException;

class EServiceReviewController extends Controller
{
    /** @var  EServiceReviewRepository */
    private $eServiceReviewRepository;

    /**
     * @var CustomFieldRepository
     */
    private $customFieldRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var EServiceRepository
     */
    private $eServiceRepository;

    public function __construct(EServiceReviewRepository $eServiceReviewRepo, CustomFieldRepository $customFieldRepo, UserRepository $userRepo
        , EServiceRepository $eServiceRepo)
    {
        parent::__construct();
        $this->eServiceReviewRepository = $eServiceReviewRepo;
        $this->customFieldRepository = $customFieldRepo;
        $this->userRepository = $userRepo;
        $this->eServiceRepository = $eServiceRepo;
    }

    /**
     * Display a listing of the EServiceReview.
     *
     * @param EServiceReviewDataTable $eServiceReviewDataTable
     * @return Response
     */
    public function index(EServiceReviewDataTable $eServiceReviewDataTable)
    {
        return $eServiceReviewDataTable->render('e_service_reviews.index');
    }

    /**
     * Show the form for creating a new EServiceReview.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        Flash::error(__('Reviews can only be managed (viewed or deleted), not created from admin.'));
        return redirect(route('eServiceReviews.index'));
    }

    /**
     * Store a newly created EServiceReview in storage.
     *
     * @param CreateEServiceReviewRequest $request
     *
     * @return Application|RedirectResponse|Redirector|Response
     */
    public function store(CreateEServiceReviewRequest $request)
    {
        Flash::error(__('Reviews can only be managed (viewed or deleted), not created from admin.'));
        return redirect(route('eServiceReviews.index'));
    }

    /**
     * Display the specified EServiceReview.
     *
     * @param int $id
     *
     * @return Application|Factory|Response|View
     * @throws RepositoryException
     */
    public function show($id)
    {
        $this->eServiceReviewRepository->pushCriteria(new EServiceReviewsOfUserCriteria(auth()->id()));
        $eServiceReview = $this->eServiceReviewRepository->findWithoutFail($id);

        if (empty($eServiceReview)) {
            Flash::error(__('lang.not_found', ['operator' => __('lang.e_service_review')]));
            return redirect(route('eServiceReviews.index'));
        }
        return view('e_service_reviews.show')->with('eServiceReview', $eServiceReview);
    }

    /**
     * Show the form for editing the specified EServiceReview.
     *
     * @param int $id
     *
     * @return Application|RedirectResponse|Redirector|Response
     * @throws RepositoryException
     */
    public function edit(int $id)
    {
        Flash::error(__('Reviews can only be managed (viewed or deleted), not edited from admin.'));
        return redirect(route('eServiceReviews.index'));
    }

    /**
     * Update the specified EServiceReview in storage.
     *
     * @param int $id
     * @param UpdateEServiceReviewRequest $request
     *
     * @return Application|RedirectResponse|Redirector|Response
     * @throws RepositoryException
     */
    public function update(int $id, UpdateEServiceReviewRequest $request)
    {
        Flash::error(__('Reviews can only be managed (viewed or deleted), not edited from admin.'));
        return redirect(route('eServiceReviews.index'));
    }

    /**
     * Remove the specified EServiceReview from storage.
     *
     * @param int $id
     *
     * @return Application|RedirectResponse|Redirector|Response
     */
    public function destroy(int $id)
    {
        $eServiceReview = $this->eServiceReviewRepository->findWithoutFail($id);

        if (empty($eServiceReview)) {
            Flash::error(__('lang.not_found', ['operator' => __('lang.e_service_review')]));
            return redirect(route('eServiceReviews.index'));
        }

        $this->eServiceReviewRepository->delete($id);

        Flash::success(__('lang.deleted_successfully', ['operator' => __('lang.e_service_review')]));
        return redirect(route('eServiceReviews.index'));
    }

    /**
     * Remove Media of EServiceReview
     * @param Request $request
     * @throws RepositoryException
     */
    public function removeMedia(Request $request)
    {
        $input = $request->all();
        $this->eServiceReviewRepository->pushCriteria(new EServiceReviewsOfUserCriteria(auth()->id()));
        $eServiceReview = $this->eServiceReviewRepository->findWithoutFail($input['id']);
        try {
            if ($eServiceReview->hasMedia($input['collection'])) {
                $eServiceReview->getFirstMedia($input['collection'])->delete();
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

}
