<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class MahasiswaController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //fungsi eloquent menampilkan data menggunakan pagination
        //$mahasiswas =DB::table('Mahasiswa')->paginate(5);
        //return view('mahasiswas.index', compact('mahasiswas'));

        // baru
        $mahasiswas = Mahasiswa::all();
        $mahasiswas = Mahasiswa::OrderBy('Nim', 'asc')->paginate(5);
        return view('mahasiswas.index', ['mahasiswas' => $mahasiswas]);
    }

    public function create()
    {
        $Kelas = Kelas::all(); //mendapatkan data dari tabel kelas
        return view('mahasiswas.create', ['Kelas' => $Kelas]);
    }

    public function store(Request $request)
    {

    //melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'image' => 'required',
            'No_Handphone' => 'required',
            'email' => 'required',
            'TTL' => 'required',            
        ]);

        $mahasiswa = new Mahasiswa;
        $mahasiswa->nim = $request->get('Nim');
        $mahasiswa->nama = $request->get('Nama');
        $mahasiswa->jurusan = $request->get('Jurusan');
        if($request->file('image')){
            $file = $request->file('image')->store('images', 'public');
            $mahasiswa->image = $file;
        }
        $mahasiswa->no_handphone = $request->get('No_Handphone');
        $mahasiswa->email = $request->get('email');
        $mahasiswa->ttl = $request->get('TTL');
        $mahasiswa->save();

        $kelas = new Kelas;
        $kelas = $request->get('nama_kelas');
        $mahasiswa->save();

        //fungsi eloquent untuk menambah data dngan relasi belongsTo
        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();

        //fungsi eloquent untuk menambah data
        //Mahasiswa::create($request->all());

        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('mahasiswas.index')
            ->with('success', 'Mahasiswa Berhasil Ditambahkan');
    }

    public function nilai($Nim)
    {
        $mahasiswa = Mahasiswa::with('kelas')->find($Nim);

        $nilaiMhs = DB::table('nilaiMhs')
            ->join('nilai', 'nilai.mata_kuliah', '=', 'nilaiMhs.mata_kuliah')
            ->join('mahasiswa', 'mahasiswa.Nim', '=', 'nilaiMhs.Nim')
            ->select('nilaiMhs.*', 'nilai.*')
            ->where('nilaiMhs.Nim', $Nim)
            ->get();
        
        return view('mahasiswas.nilai', compact('mahasiswa', 'nilaiMhs'));

    }

    public function cetak_pdf($Nim)
    {
        $mahasiswa = Mahasiswa::with('kelas')->find($Nim);
        $nilaiMhs = DB::table('nilaiMhs')
        ->join('nilai', 'nilai.mata_kuliah', '=', 'nilaiMhs.mata_kuliah')
        ->join('mahasiswa', 'mahasiswa.Nim', '=', 'nilaiMhs.Nim')
        ->select('nilaiMhs.*', 'nilai.*')
        ->where('nilaiMhs.Nim', $Nim)
        ->get();

            $pdf = PDF::loadview('mahasiswas.pdf', compact('mahasiswa','nilaiMhs'));
        return $pdf->stream();
    }

    public function show($Nim)
    {
        //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
        $Mahasiswa = Mahasiswa::find($Nim);
        return view('mahasiswas.detail', compact('Mahasiswa'));
    }

    public function edit($Nim)
    {

 //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
        $Mahasiswa = Mahasiswa::find($Nim);
        return view('mahasiswas.edit', compact('Mahasiswa'));
    }

    public function update(Request $request, $Nim)
    {

 //melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'image' => 'required',
            'No_Handphone' => 'required',
            'email' => 'required',
            'TTL' => 'required',
        ]);

//fungsi eloquent untuk mengupdate data inputan kita
Mahasiswa::find($Nim)->update($request->all());

//jika data berhasil diupdate, akan kembali ke halaman utama
        return redirect()->route('mahasiswas.index')
            ->with('success', 'Mahasiswa Berhasil Diupdate');
    }
    public function destroy( $Nim)
     {
 //fungsi eloquent untuk menghapus data
         Mahasiswa::find($Nim)->delete();
        return redirect()->route('mahasiswas.index')
            -> with('success', 'Mahasiswa Berhasil Dihapus');
     }


     public function search(Request $request)
	{
		// menangkap data pencarian
		$keyword = $request->seacrh;
 
    		// mengambil data dari table mahasiswa sesuai pencarian data
		$mahasiswa = Mahasiswa::where('nama', 'like', '%'.$keyword.'%')->paginate(5);
 
    		// mengirim data mahasiswa ke view index
		return view('mahasiswas.index', compact('mahasiswas'));
 
	}
};

