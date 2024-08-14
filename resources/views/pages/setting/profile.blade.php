@extends('layouts.app')

@section('title', 'Profile')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/bootstrap-social/assets/css/bootstrap.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Profile</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Profile</div>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="section-body">
                <h2 class="section-title">Hi, {{ auth()->user()->name }}</h2>
                <p class="section-lead">
                    Change information about yourself on this page.
                </p>
            </div>
            <div class="section-body">
                <div class="row">
                  <div class="col-lg-5">
                    <div class="card mb-4">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-sm-3">
                            <p class="mb-0">Full Name</p>
                          </div>
                          <div class="col-sm-9">
                            <p class="text-muted mb-0">{{ auth()->user()->name }}</p>
                          </div>
                        </div>
                        <hr>
                        <div class="row">
                          <div class="col-sm-3">
                            <p class="mb-0">Email</p>
                          </div>
                          <div class="col-sm-9">
                            <p class="text-muted mb-0">{{ auth()->user()->email }}</p>
                          </div>
                        </div>
                        <hr>
                        <div class="row">
                          <div class="col-sm-3">
                            <p class="mb-0">Phone</p>
                          </div>
                          <div class="col-sm-9">
                            <p class="text-muted mb-0">{{ auth()->user()->phone }}</p>
                          </div>
                        </div>
                        <hr>
                        <div class="row">
                          <div class="col-sm-3">
                            <p class="mb-0">Role</p>
                          </div>
                          <div class="col-sm-9">
                            <p class="text-muted mb-0">{{ auth()->user()->roles }}</p>
                          </div>
                        </div>
                      </div>
                    </div>
                    </div>
                  </div>
                </div>
                <div class="section-body">
                    <div class="row">
                        <div class="col-12">
                            <a href="{{ route('user.editProfile') }}" class="btn btn-primary">Edit Profile</a>
                            {{-- <a href="#">Edit Profile</a> --}}
                        </div>
                    </div>
                </div>
            </div>
            {{-- button ke halaman edit --}}



        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/summernote/dist/summernote-bs4.js') }}"></script>

    <!-- Page Specific JS File -->
@endpush
