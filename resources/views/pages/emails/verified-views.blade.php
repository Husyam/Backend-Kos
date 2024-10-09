@extends('layouts.email')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
    <style>
        .gambar {
            max-width: 400px;
            max-height: 200px;
        }
        .card-body {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
    </style>
@endpush

@section('main')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header justify-content-center">Verifikasi Email Berhasil</div>
                <div class="card-body">
                    <img src="https://img.freepik.com/free-vector/mobile-login-concept-illustration_114360-83.jpg" class="gambar" alt="mobile login concept illustration">
                    <p>{{ $message }}</p>
                    <p>Silakan Login kembali kedalam aplikasi.</p>
                    {{-- <a href="{{ route('home') }}" class="btn btn-primary">Kembali ke Halaman Utama</a> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
