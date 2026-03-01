<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\StyleQuizQuestion;
use Illuminate\Http\Request;

class StyleQuizAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $questions = StyleQuizQuestion::with('options')->orderBy('order', 'asc')->get();
            return response()->json(['success' => true, 'data' => $questions]);
        } catch (\Exception $e) {
            return response()->json(['success' => true, 'data' => [], 'message' => 'Style quiz not configured']);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
