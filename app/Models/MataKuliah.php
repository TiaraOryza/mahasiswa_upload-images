<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\MataKuliah;
use Illuminate\Database\Eloquent\Model;

class Matakuliah extends Model
{
    protected $table="nilai";

    protected $fillable = [
        'mata_kuliah',        
        'semester',
        'sks',
    ];

    public function matakuliah(){
        return $this->hasMany(Nilai::class);

    }
}