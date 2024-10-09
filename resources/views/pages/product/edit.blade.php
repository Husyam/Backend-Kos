@extends('layouts.app')

@section('title', 'Edit Product')

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
                    <div class="breadcrumb-item">Users</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Product</h2>
                <div class="card">
                    <form action="{{ route('product.update', $product) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
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
                                    name="name" value="{{ $product->name }}">
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
                                    name="name_owner" value="{{ $product->name_owner }}">
                                @error('name_owner')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- <div class="form-group">
                                <label>category gender</label>
                                <input type="text"
                                    class="form-control @error('category_gender')
                                is-invalid
                            @enderror"
                                    name="category_gender" value="{{ $product->category_gender }}">
                                @error('category_gender')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div> --}}

                            <div class="form-group">
                                <label>Category Gender</label>
                                <select class="form-control @error('category_gender') is-invalid @enderror" name="category_gender">
                                    <option value="Laki-Laki" {{ $product->category_gender == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                                    <option value="Perempuan" {{ $product->category_gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    <option value="Campuran" {{ $product->category_gender == 'Campuran' ? 'selected' : '' }}>Campuran</option>
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
                                    class="form-control @error('text')
                                is-invalid
                            @enderror"
                                    name="no_kontak" value="{{ $product->no_kontak }}">
                                @error('no_kontak')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Price</label>
                                <input type="text"
                                    class="form-control @error('text')
                                is-invalid
                            @enderror"
                                    name="price" value="{{ $product->price }}">
                                @error('price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- rental_type Hari, Minggu, Bulana, Tahun --}}
                            <div class="form-group
                                ">
                                <label>Rental Type</label>
                                <select class="form-control @error('rental_type') is-invalid @enderror" name="rental_type">
                                    <option value="Hari" {{ $product->rental_type == 'Hari' ? 'selected' : '' }}>Hari</option>
                                    <option value="Minggu" {{ $product->rental_type == 'Minggu' ? 'selected' : '' }}>Minggu</option>
                                    <option value="Bulan" {{ $product->rental_type == 'Bulan' ? 'selected' : '' }}>Bulan</option>
                                    <option value="Tahun" {{ $product->rental_type == 'Tahun' ? 'selected' : '' }}>Tahun</option>
                                </select>
                                @error('rental_type')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label>description</label>
                                <input type="text"
                                    class="form-control @error('description')
                                is-invalid
                            @enderror"
                                    name="description" value="{{ $product->description}}">
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group ">
                                <label>Fasilitas</label>
                                <div class="checkbox">
                                    @foreach ($facilities as $facility)
                                        <label>
                                            <input type="checkbox" name="fasilitas[]" value="{{ $facility }}"
                                                   @if(in_array($facility, json_decode($product->fasilitas, true))) checked @endif
                                            > {{ $facility }}
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
                                    name="stock" value="{{ $product->stock}}">
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
                                    name="address" value="{{ $product->address}}">
                                @error('address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Latitude</label>
                                <input type="text"
                                    class="form-control @error('latitude') is-invalid @enderror"
                                    name="latitude" value="{{ old('latitude', $product->latitude) }}">
                                @error('latitude')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Longitude</label>
                                <input type="text"
                                    class="form-control @error('longitude') is-invalid @enderror"
                                    name="longitude" value="{{ old('longitude', $product->longitude) }}">
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
                                            {{ $product->id_category == $category->id_category ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Photo Product</label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control" name="image"
                                        @error('image') is-invalid @enderror>
                                </div>
                                @error('image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Photo Product</label>
                                <div class="col-sm-9">
                                    @if ($product->multi_image)
                                        @foreach (json_decode($product->multi_image, true) as $image)
                                            <img src="{{ asset('storage/products/multi/' . $image) }}" alt="" width="100">
                                        @endforeach
                                    @endif
                                    <input type="file" class="form-control" name="images[]" multiple>
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
