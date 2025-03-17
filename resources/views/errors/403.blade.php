@extends('app.main')
@section('title', 'Akses Ditolak')

@section('content')
<div class="container text-center mt-5">
    <h1 class="text-danger">403 - Forbidden</h1>
    <p>Maaf, Anda tidak memiliki akses ke halaman ini.</p>
    <a href="{{ url('/') }}" class="btn btn-primary">Kembali ke Beranda</a>
</div>
@endsection