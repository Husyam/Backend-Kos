@extends('layouts.auth')

@section('title', 'Reset Password')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-social/bootstrap-social.css') }}">
    <style>
        .readonly-email {
            background-color: #e9ecef;
            cursor: not-allowed;
        }
    </style>
@endpush

@section('main')
    <div class="card card-primary">
        <div class="card-header">
            <h4>Reset Password</h4>
        </div>

        <div class="card-body">
            <p class="text-muted">Enter your new password</p>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control readonly-email" name="email"
                        value="{{ $request->email ?? old('email') }}" required autocomplete="email"
                        readonly tabindex="-1">
                    @error('email')
                        <div class="alert alert-danger mt-2">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">New Password</label>
                    <input id="password" type="password"
                        class="form-control pwstrength @error('password') is-invalid @enderror"
                        data-indicator="pwindicator" name="password" required
                        autocomplete="new-password" placeholder="Enter New Password">
                    @error('password')
                        <div class="alert alert-danger mt-2">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password-confirm">Confirm Password</label>
                    <input id="password-confirm" type="password" class="form-control"
                        name="password_confirmation" tabindex="4" required
                        autocomplete="new-password" placeholder="Confirm New Password">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                        Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var emailField = document.getElementById('email');
            emailField.addEventListener('keydown', function(e) {
                e.preventDefault();
                return false;
            });
        });
    </script>
@endpush
