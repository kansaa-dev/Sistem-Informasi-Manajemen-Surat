@extends('layout.app')

@section('title', 'Daftar Surat Keluar')

@section('content')
<h1>Daftar Surat Keluar</h1>
<button>
    <a href="{{ route('surat-keluar.create') }}">+ Tambah Surat</a>
</button>


@if (session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>No</th>
            <th>Nomor Surat</th>
            <th>Tanggal</th>
            <th>Tujuan</th>
            <th>Perihal</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($suratKeluar as $surat)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $surat->nomor_surat }}</td>
                <td>{{ $surat->tanggal }}</td>
                <td>{{ $surat->tujuan }}</td>
                <td>{{ $surat->perihal }}</td>
                <td>
                <button>
                    <a href="{{ route('surat-keluar.show', $surat->id) }}">Detail</a>
                </button>
                    
                <button>
                    <a href="{{ route('surat-keluar.edit', $surat->id) }}">Edit</a>
                </button>
                    
                    <form action="{{ route('surat-keluar.destroy', $surat->id) }}"
                          method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            onclick="return confirm('Hapus surat ini?')">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">Belum ada surat keluar.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection