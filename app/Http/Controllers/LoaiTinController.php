<?php

namespace App\Http\Controllers;

use App\Models\LoaiTin;
use Illuminate\Http\Request;
use App\Http\Resources\LoaiTinResource;
use App\Http\Resources\TinResource;

class LoaiTinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $loaiTins = LoaiTin::all();
        return response()->json($loaiTins);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Ten_loaitin' => 'required|string|max:255',
            'Trangthai' => 'boolean'
        ]);

        $loaiTin = LoaiTin::create($request->all());
        return response()->json($loaiTin, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(LoaiTin $loaiTin)
    {
        return response()->json($loaiTin);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LoaiTin $loaiTin)
    {
        $request->validate([
            'Ten_loaitin' => 'string|max:255',
            'Trangthai' => 'boolean'
        ]);

        $loaiTin->update($request->all());
        return response()->json($loaiTin);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LoaiTin $loaiTin)
    {
        $loaiTin->delete();
        return response()->json(null, 204);
    }

    public function getTinByLoaiTin(LoaiTin $loaiTin)
    {
        $tin = $loaiTin->tin()->where('Trangthai', true)->get();
        return TinResource::collection($tin);
    }
}
