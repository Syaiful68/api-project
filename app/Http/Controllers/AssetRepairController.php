<?php

namespace App\Http\Controllers;

use App\Models\AssetRepair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AssetRepairController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'data' => AssetRepair::all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'tags' => 'required',
            'description' => 'required'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'error' => $validation->errors()
            ], 422);
        }
        AssetRepair::create([
            'asset_id' => $request->tags,
            'description' => $request->description,
            'user_id' => Auth::user()->id
        ]);
        return response()->json([
            'success' => 'Data has been created'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $assetRepair)
    {
        //
        $query = AssetRepair::query()->where('id', $assetRepair);
        if ($query->first() === null) {
            return response()->json([
                'message' => 'data not found'
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
    public function update(Request $request, string $assetRepair)
    {
        //
        $query = AssetRepair::query()->where('id', $assetRepair);
        if ($query->first() === null) {
            return response()->json([
                'message' => 'data not found'
            ], 404);
        }

        $query->update([
            'handle' => $request->handle,
            'status' => $request->status,
            'user_handle' => Auth::user()->id
        ]);
        return response()->json([
            'message' => 'Data has been updated'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AssetRepair $assetRepair)
    {
        //
        $query = AssetRepair::query()->where('id', $assetRepair);
        if ($query->first() === null) {
            return response()->json([
                'message' => 'data not found'
            ], 404);
        }

        $query->delete();
        return response()->json([
            'message' => 'Data has been deleted'
        ], 200);
    }
}
