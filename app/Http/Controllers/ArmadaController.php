<?php

namespace App\Http\Controllers;

use App\Models\Armada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ArmadaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'data' => Armada::all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validation = Validator::make($request->all(), [
            'plat' => 'required|unique:tb_armadas,plat_number',
            'owner' => 'required',
            'fuels' => 'required',
            'type' => 'required',
            'name' => 'required'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'errors' => $validation->errors()
            ], 422);
        }

        Armada::create([
            'plat' => $request->plat,
            'owner' => $request->owner,
            'fuels' => $request->fuels,
            'type' => $request->type,
            'name' => $request->name,
            'user_id' => Auth::user()->id
        ]);

        return response()->json([
            'success' => 'Data has been created'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Armada $armada)
    {
        //
        $query = Armada::query()->where('id', $armada);
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
    public function update(Request $request, Armada $armada)
    {
        //
        $query = Armada::query()->where('id', $armada);
        if ($query->first() === null) {
            return response()->json([
                'message' => 'Data not found'
            ], 404);
        }

        $query->update([
            'status' => $request->status
        ]);
        return response()->json([
            'success' => 'Data has been updated'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Armada $armada)
    {
        //
        $query = Armada::query()->where('id', $armada);
        if ($query->first() === null) {
            return response()->json([
                'message' => 'Data not found'
            ], 404);
        }
        $query->delete();
        return response()->json([
            'success' => 'Data has been updated'
        ], 200);
    }
}
