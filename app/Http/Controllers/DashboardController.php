<?php

namespace App\Http\Controllers;

use App\Models\Tin;
use App\Models\BinhLuan;
use App\Models\User;

class DashboardController extends Controller
{
    public function statistics()
    {
        $stats = [
            'total_tins' => Tin::count(),
            'total_comments' => BinhLuan::count(),
            'total_users' => User::count(),
            'hot_tins' => Tin::where('Tinhot', true)->count(),
            'pending_comments' => BinhLuan::where('Trangthai', false)->count()
        ];

        return response()->json($stats);
    }
} 