<?php

namespace App\Http\Controllers;

use App\Models\Assets;
use App\Models\ProfileAsset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use function PHPSTORM_META\map;

class AssetsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'data' => Assets::all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'item' => 'required',
            'pic' => 'required',
            'location' => 'required'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'errors' => $validation->errors()
            ], 422);
        }

        $asset = Assets::create([
            'item' => $request->item,
            'user_id' => Auth::user()->id
        ]);

        ProfileAsset::create([
            'asset_id' => $asset->id,
            'pic' => $request->pic,
            'location' => $request->location,
            'user_id' => Auth::user()->id
        ]);
        return response()->json([
            'success' => 'Data has been created'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Assets $assets)
    {
        //
        $query = Assets::query()->where('id', $assets);
        if ($query->first() === null) {
            return response()->json([
                'message' => 'Data not found'
            ], 404);
        }
        $data = $query->get();
        $profile = ProfileAsset::query()->where('asset_id', $assets)->get();
        return response()->json([
            'data' => $data,
            'profile' => $profile
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Assets $assets)
    {
        $query = Assets::query()->where('id', $assets);
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
    public function destroy(Assets $assets)
    {
        //
    }
}
