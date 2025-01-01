<?php

namespace App\Http\Controllers;

use App\Models\ProfileAsset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileAssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'pic' => 'required',
            'location' => 'required'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'errors' => $validation->errors()
            ], 422);
        }

        ProfileAsset::create([
            'asset_id' => $request->asset,
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
    public function show(ProfileAsset $profileAsset)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProfileAsset $profileAsset)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProfileAsset $profileAsset)
    {
        //
    }
}
