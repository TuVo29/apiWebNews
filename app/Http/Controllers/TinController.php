<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tin;
use Illuminate\Http\Request;
use App\Http\Resources\TinResource;
use Illuminate\Support\Facades\Storage;

class TinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Tin::with('loaiTin');

        if ($request->has('search')) {
            $query->where('Tieude', 'like', '%' . $request->search . '%');
        }

        $tins = $query->paginate(10);

        return response()->json($tins);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Tieude' => 'required|string|max:255',
            'Hinhdaidien' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'Mota' => 'required|string',
            'Noidung' => 'required|string',
            'Tacgia' => 'required|string|max:255',
            'Tinhot' => 'boolean',
            'Trangthai' => 'boolean',
            'Id_loaitin' => 'required|exists:loai_tin,Id_loaitin'
        ]);

        $data = $request->all();

        if ($request->hasFile('Hinhdaidien')) {
            $path = $request->file('Hinhdaidien')->store('public/images');
            $data['Hinhdaidien'] = Storage::url($path);
        }

        $tin = Tin::create($data);

        return response()->json($tin, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tin $tin)
    {
        $tin->increment('Solanxem');
        return new TinResource($tin->load('loaiTin', 'binhLuan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tin $tin)
    {
        $request->validate([
            'Tieude' => 'string|max:255',
            'Hinhdaidien' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'Mota' => 'string',
            'Noidung' => 'string',
            'Tacgia' => 'string|max:255',
            'Tinhot' => 'boolean',
            'Trangthai' => 'boolean',
            'Id_loaitin' => 'exists:loai_tin,Id_loaitin'
        ]);

        $data = $request->all();

        if ($request->hasFile('Hinhdaidien')) {
            if ($tin->Hinhdaidien) {
                Storage::delete(str_replace('/storage', 'public', $tin->Hinhdaidien));
            }
            $path = $request->file('Hinhdaidien')->store('public/images');
            $data['Hinhdaidien'] = Storage::url($path);
        }

        $tin->update($data);

        return response()->json($tin);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tin $tin)
    {
        if ($tin->Hinhdaidien) {
            Storage::delete(str_replace('/storage', 'public', $tin->Hinhdaidien));
        }
        $tin->delete();
        return response()->json(null, 204);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $tin = Tin::where('Trangthai', true)
            ->where(function($q) use ($query) {
                $q->where('Tieude', 'like', "%{$query}%")
                  ->orWhere('Mota', 'like', "%{$query}%")
                  ->orWhere('Noidung', 'like', "%{$query}%");
            })
            ->get();
        return TinResource::collection($tin);
    }

    public function getTinHot()
    {
        $tin = Tin::where('Trangthai', true)
            ->where('Tinhot', true)
            ->get();
        return TinResource::collection($tin);
    }
}
