
@extends('layout.app')

@section('title', 'Halaman Surat Masuk')

@section('content')

<h1>Halaman Surat Masuk</h1>

@if (session('success'))
    <p style="color: green;">
        {{ session('success') }}
    </p>
@endif

@can('manage-letters')
<button>
        <a href="{{ route('surat-masuk.create') }}">+ Tambah Surat</a>
</button>

@endcan

<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>No</th>
            <th>Nomor Surat</th>
            <th>Tanggal</th>
            <th>Pengirim</th>
            <th>Perihal</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($suratMasuk as $surat)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $surat->nomor_surat }}</td>
                <td>{{ $surat->tanggal }}</td>
                <td>{{ $surat->pengirim }}</td>
                <td>{{ $surat->perihal }}</td>

                <td>
                    <button>
                    <a href="{{ route('surat-masuk.show', $surat->id) }}">
                        Detail Surat
                    </a>
                    </button>

                    @can('manage-letters')
                    <button>
                        <a href="{{ route('surat-masuk.edit', $surat->id) }}">Edit Surat</a>
                    </button>
                        

                        <form action="{{ route('surat-masuk.destroy', $surat->id) }}"
                              method="POST"
                              style="display: inline;">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                onclick="return confirm('Hapus Surat ini?')">
                                Hapus
                            </button>
                        </form>
                    @endcan
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">Belum ada data surat masuk.</td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection
