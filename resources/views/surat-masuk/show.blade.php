@extends('layout.app')
@section('title', 'Detail Surat Masuk')
@section('content')
<h1>Detail Surat Masuk</h1>
<p>Nomor: {{ $surat->nomor_surat }}</p>
<p>Tanggal: {{ $surat->tanggal }}</p>
<p>Pengirim: {{ $surat->pengirim }}</p>
<p>Perihal: {{ $surat->perihal }}</p>
<p>Keterangan: {{ $surat->keterangan ?? '-' }}</p>

<button>
    <a href="{{ route('surat-masuk.index') }}">Kembali</a>
</button>

@endsection
