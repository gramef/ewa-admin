<?php
/*
 * File name: ModuleAPIController.php
 * Last modified: 2022.04.01 at 23:11:05
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2022
 */

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Nwidart\Modules\Facades\Module;

/**
 * Class ModuleAPIController
 * @package App\Http\Controllers\API
 */
class ModuleAPIController extends Controller
{

    /**
     * Display a listing of the Module.
     * GET|HEAD /modules
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            // Try to get modules from the Laravel Modules package first
            $array = Module::allEnabled();
            $array = array_keys($array);
            
            // If no modules found from the package, read from modules_statuses.json
            if (empty($array)) {
                $statusFile = base_path('modules_statuses.json');
                if (file_exists($statusFile)) {
                    $moduleStatuses = json_decode(file_get_contents($statusFile), true);
                    if ($moduleStatuses) {
                        $array = array_keys(array_filter($moduleStatuses, function($status) {
                            return $status === true;
                        }));
                    }
                }
            }
        } catch (\Exception $e) {
            // Fallback to reading from modules_statuses.json if Module facade fails
            $array = [];
            $statusFile = base_path('modules_statuses.json');
            if (file_exists($statusFile)) {
                $moduleStatuses = json_decode(file_get_contents($statusFile), true);
                if ($moduleStatuses) {
                    $array = array_keys(array_filter($moduleStatuses, function($status) {
                        return $status === true;
                    }));
                }
            }
        }
        
        return $this->sendResponse($array, 'Modules retrieved successfully');
    }

}
