<?php

namespace App\Models;

 use Illuminate\Contracts\Auth\MustVerifyEmail;
 use Illuminate\Database\Eloquent\Factories\HasFactory;
 use Illuminate\Foundation\Auth\Mahasiswa as Authenticatable;
 use Illuminate\Notifications\Notifiable;
 use Illuminate\Database\Eloquent\Model; //Model Eloquent
 use App\Models\Mahasiswa;

class Mahasiswa extends Model //Definisi Model
{
    protected $table="mahasiswa"; // Eloquent akan membuat model mahasiswa menyimpan record di tabel mahasiswas 
    protected  $primaryKey = 'Nim'; // Memanggil isi DB Dengan primarykey
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Nim',
        'Nama',
        'kelas_id',
        'Jurusan',
        'image',
        'No_Handphone',
        'email',
        'TTL',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
};
