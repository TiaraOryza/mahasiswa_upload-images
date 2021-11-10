<?php

namespace App\Models;
use App\Models\Mahasiswa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa_MataKuliah extends Model
{
    use HasFactory;
    protected $table = 'nilaiMhs';
    protected $fillable = [
        'Nim',
        'mata_kuliah',
        'nilai',
    ];

    public function mahasiswa(){
        return $this->hasMany(Mahasiswa::class);
    }
    public function matakuliah(){
        return $this->hasMany(MataKuliah::class);
    }
}
