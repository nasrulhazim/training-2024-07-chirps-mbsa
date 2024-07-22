<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChirpCollection;
use App\Http\Resources\ChirpResource;
use App\Models\Chirp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ChirpCollection(Chirp::with('user')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|min:10|max:250',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $chirp = Chirp::create([
            'user_id' => $request->user()->id,
            'message' => $request->message,
        ]);

        return new ChirpResource($chirp);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new ChirpResource(Chirp::with('user')->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|min:10|max:250',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $chirp = Chirp::findOrFail($id);

        $chirp->update([
            'message' => $request->message,
        ]);

        $chirp->refresh();

        return new ChirpResource($chirp);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $chirp = Chirp::where('user_id', $request->user()->id)->findOrFail($id);

        $chirp->delete();

        return response()->json([
            'message' => 'You have successfully delete the record.'
        ]);
    }
}
