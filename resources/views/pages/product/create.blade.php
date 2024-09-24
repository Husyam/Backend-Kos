@extends('layouts.app')

@section('title', 'Product Create')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Advanced Forms</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Forms</a></div>
                    <div class="breadcrumb-item">Product</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Product</h2>



                <div class="card">
                    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-header">
                            <h4>Input Text</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text"
                                    class="form-control @error('name')
                                is-invalid
                            @enderror"
                                    name="name">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Name Owner</label>
                                <input type="text"
                                    class="form-control @error('name_owner')
                                is-invalid
                            @enderror"
                                    name="name_owner">
                                @error('name_owner')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- <div class="form-group">
                                <label>Category Gender</label>
                                <input type="text"
                                    class="form-control @error('category_gender')
                                is-invalid
                            @enderror"
                                    name="category_gender">
                                @error('category_gender')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div> --}}

                            <div class="form-group">
                                <label>Category Gender</label>
                                <select class="form-control @error('category_gender') is-invalid @enderror" name="category_gender">
                                    <option value="Laki-Laki">Laki-Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                    <option value="Campuran">Campuran</option>
                                </select>
                                @error('category_gender')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>No Kontak</label>
                                <input type="number"
                                    class="form-control @error('no_kontak')
                                is-invalid
                            @enderror"
                                    name="no_kontak">
                                @error('no_kontak')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Price</label>
                                <input type="number"
                                    class="form-control @error('price')
                                is-invalid
                            @enderror"
                                    name="price">
                                @error('price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- <div class="form-group">
                                <label>Description</label>
                                <input type="text"
                                    class="form-control @error('description')
                                is-invalid
                            @enderror"
                                    name="description">
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div> --}}


                            <div class="form-group mb-0">
                                <label>Description</label>
                                <textarea
                                    class="form-control @error('description') is-invalid @enderror"
                                    name="description"
                                    rows="4"
                                    data-height="150"
                                    required
                                ></textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mt-3 ">
                                <label>Fasilitas</label>
                                <div class="checkbox">
                                    @foreach ($facilities as $facility)
                                        <label>
                                            <input class="mr-2" type="checkbox" name="fasilitas[]" value="{{ $facility }}">{{ $facility }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Stock</label>
                                <input type="number"
                                    class="form-control @error('stock')
                                is-invalid
                            @enderror"
                                    name="stock">
                                @error('stock')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Address</label>
                                <input type="text"
                                    class="form-control @error('address')
                                is-invalid
                            @enderror"
                                    name="address">
                                @error('address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="activity">
                                <div class="activity-detail">
                                    <div class="mb-2">
                                        <span class="text-job">Cara Mendapatkan latitude dan longitute</span>
                                    </div>
                                    <div class="image-container mb-2">
                                        <img src="{{ asset('storage/public/image/lat_log.png') }}" alt="Tutorial Image" class="img-fluid" width="500" height="auto">
                                    </div>
                                    <a  href="https://youtube.com/shorts/fvw3dzlZDhc?si=snevNQExd4oYzSVi" target="_blank">Berikut Video Tutotial </a>
                                </div>
                            </div>

                            <div class="form-group mt-4" >
                                <label>Latitude</label>
                                <input type="text"
                                    class="form-control @error('latitude')
                                is-invalid
                            @enderror"
                                    name="latitude">
                                @error('latitude')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Longitude</label>
                                <input type="text"
                                    class="form-control @error('longitude')
                                is-invalid
                            @enderror"
                                    name="longitude">
                                @error('longitude')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">Category</label>
                                <select class="form-control @error('id_category') is-invalid @enderror" name="id_category">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id_category }}"
                                            {{ old('id_category') == $category->id_category ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Photo Product</label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control" name="image" accept="image/*"
                                        @error('image') is-invalid @enderror>
                                </div>
                                @error('image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Multi Image</label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control" name="images[]" multiple accept="image/*">
                                </div>
                            </div>


                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>

            </div>
        </section>
    </div>
@endsection

@push('scripts')
@endpush
