<?php

namespace App\Http\Controllers;

use App\Models\code_order;
use Illuminate\Http\Request;

class CodeOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $code = code_order::query();
        if ($code->first('id') === null) {
            $n = 1;
        } else {
            $n = $code->latest()->first()->id + 1;
        }
        dd($n);
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
    public function show(code_order $code_order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, code_order $code_order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(code_order $code_order)
    {
        //
    }
}
