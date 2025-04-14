<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoaiTin;
use Illuminate\Http\Request;
use App\Http\Resources\LoaiTinResource;

class LoaiTinControllerAdmin extends Controller
{
    // Lấy tất cả loại tin (kể cả chưa duyệt)
    public function index()
    {
        $loaiTin = LoaiTin::all();
        return LoaiTinResource::collection($loaiTin);
    }

    // Xem chi tiết 1 loại tin
    public function show($id)
    {
        $loaiTin = LoaiTin::findOrFail($id);
        return new LoaiTinResource($loaiTin);
    }

    // Cập nhật loại tin
    public function update(Request $request, $id)
    {
        $request->validate([
            'Ten_loaitin' => 'required|string|max:255',
            'Trangthai' => 'boolean'
        ]);

        $loaiTin = LoaiTin::findOrFail($id);
        $loaiTin->update($request->all());

        return new LoaiTinResource($loaiTin);
    }

    // Xoá loại tin
    public function destroy($id)
    {
        $loaiTin = LoaiTin::findOrFail($id);
        $loaiTin->delete();

        return response()->json(['message' => 'Đã xoá loại tin'], 200);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'Id_loaitin' => 'required|string|max:255',
                'Ten_loaitin' => 'required|string|max:255',
                'Trangthai' => 'boolean'
            ]);
        
            // Tạo bản ghi
            $loaiTin = LoaiTin::create($validatedData);
        
            return response()->json($loaiTin, 201);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors()
            ], 422);
    
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Đã xảy ra lỗi trong quá trình lưu loại tin',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}