<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoaiTin extends Model
{
    use HasFactory;

    protected $table = 'loai_tin';
    protected $primaryKey = 'Id_loaitin';
    public $timestamps = false;

    protected $fillable = [
        'Id_loaitin',
        'Ten_loaitin',
        'Trangthai'
    ];

    protected $casts = [
        'Id_loaitin' => 'string',
        'Trangthai' => 'boolean'
    ];

    public function tins()
    {
        return $this->hasMany(Tin::class, 'Id_loaitin', 'Id_loaitin');
    }
}