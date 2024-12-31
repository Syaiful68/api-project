<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            // 'data' => Orders::query()->where('user_id',Auth::user()->id)->get()
            'data' => Orders::all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'items' => 'required',
            'description' => 'required',
            'qty' => 'required',
            'price' => 'required'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'errors' => $validation->errors()
            ], 422);
        }
        Orders::create([
            'items' => $request->items,
            'description' => $request->description,
            'qty' => $request->qty,
            'price' => $request->price,
            'total' => $request->qty * $request->price,
            'user_id' => '1',
            'dept' => 'GA',
        ]);
        return response()->json([
            'success' => 'Data has been created'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Orders $orders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Orders $orders)
    {
        $query = Orders::query()->where('id', $orders);
        if ($query->first() === null) {
            return response()->json([
                'message' => 'Data not found'
            ], 404);
        }

        $query->update([
            'items' => $request->items,
            'description' => $request->description,
            'qty' => $request->qty,
            'price' => $request->price,
            'total' => $request->qty * $request->price,
            'user_id' => '1',
            'dept' => 'GA',
        ]);
        return response()->json([
            'success' => 'Data has been updated'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Orders $orders)
    {
        $query = Orders::query()->where('id', $orders);
        if ($query->first() === null) {
            return response()->json([
                'message' => 'Data not found'
            ], 404);
        }
        $query->delete();
        return response()->json([
            'message' => 'Data has been deleted'
        ], 200);
    }
}
