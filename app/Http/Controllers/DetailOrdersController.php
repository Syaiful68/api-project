<?php

namespace App\Http\Controllers;

use App\Models\code_order;
use App\Models\detail_orders;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetailOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'data' => code_order::all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $code = code_order::query();
        if ($code->first('id') === null) {
            $n = 0;
        } else {
            $n = $code->latest()->first()->id + 1;
        }
        $f = 'DTB-' . str_pad($n, 5, 0, STR_PAD_LEFT);
        $g = code_order::create([
            'code' => $f,
            'user_id' => '1',
            'status' => 'request'
        ]);
        $data = Orders::query()->where('user_id', Auth::user()->id)->get();
        foreach ($data as $key => $value) {
            detail_orders::create([
                'code_id' => $g->id,
                'items' => $value->items,
                'description' => $value->description,
                'qty' => $value->qty,
                'price' => $value->price,
                'total' => $value->total,
                'user_id' => $value->user_id,
                'dept' => $value->dept,
            ]);
        }

        Orders::query()->where('user_id', Auth::user()->id)->delete();
        return response()->json([
            'success' => 'Data has been created'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(detail_orders $detail_orders)
    {
        // 
        $query = code_order::query()->where('id', $detail_orders);
        if ($query->first() === null) {
            return response()->json([
                'message' => 'Data not found'
            ], 404);
        }

        return response()->json([
            'data' => code_order::query()->where('id', $detail_orders)->get(),
            'list' => detail_orders::query()->where('code_id', $detail_orders)->get()
        ], 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, detail_orders $detail_orders)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(detail_orders $detail_orders)
    {
        //
    }
}
