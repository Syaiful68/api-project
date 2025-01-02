<?php

namespace App\Http\Controllers;

use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'data' => Record::all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $query = Record::query();
        if ($query->where('armada_id', $request->plat)->first() === null) {
            $check = 0;
        } else {
            $check = $query->where('armada_id', $request->plat)->latest()->first()->last_mile;
        }
        // dd($check);
        $validation = Validator::make($request->all(), [
            'plat' => 'required',
            'last' =>  ['required', function ($attribute, $value, $fail) use ($check) {
                if ($value <= $check) {
                    $fail('last mile must be greater than first mile');
                }
            }],
            'cost' => 'required',
            'driver' => 'required',
            'description' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'errors' => $validation->errors()
            ], 422);
        }


        Record::create([
            'armada_id' => $request->plat,
            'first_mile' => $check,
            'last_mile' => $request->last,
            'driver' => $request->driver,
            'cost' => $request->cost,
            'description' => $request->description,
            'user_id' => Auth::user()->id,
        ]);

        return response()->json([
            'success' => 'Data has been created'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Record $record)
    {
        //
        $query = Record::query()->where('id', $record);
        if ($query->first() === null) {
            return response()->json([
                'message' => 'Data not found'
            ], 404);
        }

        $data = $query->get();
        return response()->json([
            'data' => $data
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Record $record)
    {
        //
        $query = Record::query()->where('id', $record);
        if ($query->first() === null) {
            return response()->json([
                'message' => 'Data not found'
            ], 404);
        }

        $query->update([
            'status' => $request->status
        ]);
        return response()->json([
            'message' => 'Data has been updated'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Record $record)
    {
        $query = Record::query()->where('id', $record);
        if ($query->first() === null) {
            return response()->json([
                'message' => 'Data not found'
            ], 404);
        }

        $query->delete();
        return response()->json([
            'message' => 'Data has been updated'
        ], 200);
    }
}
