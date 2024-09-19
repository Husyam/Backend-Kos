@extends('layouts.app')


@extends('layouts.app')

@section('title', 'Verify Email')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">

<div class="row">
    <div class="col-md-5 col-sm-12 mx-auto">
        <div class="card py-4">
            <div class="card-body">

                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success text-center">A new email verification link has been emailed to you!</div>
                @endif
                <div class="text-center mb-5">

                    <h3>Verify e-mail address</h3>
                    <p>You must verify your email address to access this page.</p>
                </div>
                <form method="POST" action="{{ route('verification.send') }}" class="text-center">
                    @csrf
                    <button type="submit" class="btn btn-primary">Resend verification email</button>
                </form>
            </div>

            <p class="mt-3 mb-0 text-center"><small>Issues with the verification process or entered the wrong email?
                <br>Please sign up with <a href="/register-retry">another</a> email address.</small></p>
        </div>
    </div>
</div>

    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/index-0.js') }}"></script>
@endpush
