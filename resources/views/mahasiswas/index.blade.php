@extends('mahasiswas.layout')
 
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left mt-2">
                <h2>JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h2>
            </div>
            <div class="float-right my-2">
                <a class="btn btn-success" href="{{ route('mahasiswas.create') }}"> Input Mahasiswa</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered">
        <tr>
            <th>Nim</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Jurusan</th>
            <th>No_Handphone</th>
            <th>Email</th>
            <th>Tanggal_Lahir</th>
            <th width="280px">Action</th>
        </tr>

        <form action="{{ route('search') }}" method="GET">
            <input type="text" name="search" placeholder="Cari Mahasiswa .." value="{{ old('search') }}">
            <input type="submit" value="cari">
            </form>

        @foreach ($mahasiswas as $Mahasiswa)
        <tr>
            
            <td>{{ $Mahasiswa->Nim }}</td>
            <td>{{ $Mahasiswa->Nama }}</td>
            <td>{{ $Mahasiswa->Kelas->nama_kelas }}</td>
            <td>{{ $Mahasiswa->Jurusan }}</td>
            <td>{{ $Mahasiswa->No_Handphone }}</td>
            <td>{{ $Mahasiswa->email }}</td>
            <td>{{ $Mahasiswa->TTL }}</td>
            <td>
        
            
            <form action="{{ route('mahasiswas.destroy',$Mahasiswa->Nim) }}" method="POST">
   
                    <a class="btn btn-info" href="{{ route('mahasiswas.show',$Mahasiswa->Nim) }}">Show</a>

                    <a class="btn btn-primary" href="{{ route('mahasiswas.edit',$Mahasiswa->Nim) }}">Edit</a>

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">Delete</button>
            </form>
            
            </td>
            
        @endforeach
        </tr>
    </table>
            Halaman : {{ $mahasiswas->currentPage() }} <br/>
            Jumlah Data : {{ $mahasiswas->total() }} <br/>
            Data Per Halaman : {{ $mahasiswas->perPage() }} <br/>
            <br/>
            {{ $mahasiswas->links() }}
@endsection

