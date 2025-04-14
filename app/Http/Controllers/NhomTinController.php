<?php

namespace App\Http\Controllers;

use App\Models\NhomTin;
use Illuminate\Http\Request;
use App\Http\Resources\NhomTinResource;

class NhomTinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nhomTins = NhomTin::all();
        return response()->json($nhomTins);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Ten_nhomtin' => 'required|string|max:255',
            'Trangthai' => 'boolean'
        ]);

        $nhomTin = NhomTin::create($request->all());
        return response()->json($nhomTin, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(NhomTin $nhomTin)
    {
        return response()->json($nhomTin);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NhomTin $nhomTin)
    {
        $request->validate([
            'Ten_nhomtin' => 'string|max:255',
            'Trangthai' => 'boolean'
        ]);

        $nhomTin->update($request->all());
        return response()->json($nhomTin);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NhomTin $nhomTin)
    {
        $nhomTin->delete();
        return response()->json(null, 204);
    }
}
