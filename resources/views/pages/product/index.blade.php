@extends('layouts.app')

@section('title', 'Product')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <style>
       .modal-backdrop {
            display: none;
        }
        #modal-view .modal-backdrop {
           display: none;
        }

    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Product</h1>
                <div class="section-header-button">
                    <a href="{{ route('product.create') }}" class="btn btn-primary">Add New</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Product</a></div>
                    <div class="breadcrumb-item">All Product</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">

                                <div class="float-right">
                                    <form method="GET" action="{{ route('product.index') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search" name="name">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table-striped table table-hover">
                                        <tr>

                                            <th>Name</th>
                                            <th>Category</th>
                                            <th>Name Owner</th>
                                            <th>Category Gender</th>
                                            <th>No kontak</th>
                                            <th>Price</th>
                                            <th>Description</th>
                                            <th>Fasilitas</th>
                                            <th>Stock</th>
                                            <th>Address</th>
                                            <th>latitude</th>
                                            <th>longitude</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>{{ $product->name }}
                                                </td>
                                                {{-- <td>{{ $product->category->name }}
                                                </td> --}}
                                                <td>{{ $product->category->name }}
                                                </td>

                                                <td>{{ $product->name_owner }}
                                                </td>
                                                <td>{{ $product->category_gender }}
                                                </td>
                                                <td>{{ $product->no_kontak }}
                                                </td>
                                                <td>{{ $product->price }}
                                                </td>
                                                <td>{{ $product->description }}
                                                </td>
                                                <td>
                                                    @if (is_array($product->fasilitas))
                                                        <ul>
                                                            @foreach ($product->fasilitas as $fasilitas)
                                                                <li>{{ $fasilitas }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        {{ $product->fasilitas }}
                                                    @endif
                                                </td>
                                                <td>{{ $product->stock }}
                                                </td>
                                                <td>{{ $product->address }}
                                                </td>
                                                <td>{{ $product->latitude }}
                                                </td>
                                                <td>{{ $product->longitude }}
                                                </td>
                                                <td>{{ $product->created_at }}</td>

                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        {{-- buton view example and icon  --}}
                                                        <button type="button" class="btn btn-sm btn-primary mr-2" data-toggle="modal" data-target="#productModal{{ $product->id_product }}">
                                                            <i class="fas fa-eye
                                                            "></i>
                                                            View Details
                                                        </button>

                                                        <a href='{{ route('product.edit', $product->id_product) }}'
                                                            class="btn btn-sm btn-info btn-icon">
                                                            <i class="fas fa-edit"></i>
                                                            Edit
                                                        </a>

                                                        <form action="{{ route('product.destroy', $product->id_product) }}"
                                                            method="POST" class="ml-2" enctype="multipart/form-data">
                                                            <input type="hidden" name="_method" value="DELETE" />
                                                            <input type="hidden" name="_token"
                                                                value="{{ csrf_token() }}" />
                                                            <button class="btn btn-sm btn-danger btn-icon confirm-delete">
                                                                <i class="fas fa-times"></i> Delete
                                                            </button>
                                                        </form>

                                                    </div>
                                                </td>
                                            </tr>
                                            <!-- Modal for product details -->
                                            <div class="modal fade" id="productModal{{ $product->id_product }}" tabindex="-1" role="dialog" aria-labelledby="productModalLabel{{ $product->id_product }}" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="productModalLabel{{ $product->id_product }}">{{ $product->name }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body table-responsive">
                                                            <p><strong>Owner:</strong> {{ $product->name_owner }}</p>
                                                            <p><strong>Category:</strong> {{ $product->category->name }}</p>
                                                            <p><strong>Contact:</strong> {{ $product->no_kontak }}</p>
                                                            <p><strong>Price:</strong> {{ $product->price }}</p>
                                                            <p><strong>Description:</strong> {{ $product->description }}</p>
                                                            <p><strong>Facilities:</strong></p>
                                                            <ul>
                                                                @if (is_array($product->fasilitas))
                                                                    @foreach ($product->fasilitas as $fasilitas)
                                                                        <li>{{ $fasilitas }}</li>
                                                                    @endforeach
                                                                @else
                                                                    <li>{{ $product->fasilitas }}</li>
                                                                @endif
                                                            </ul>
                                                            <p><strong>Stock:</strong> {{ $product->stock }}</p>
                                                            <p><strong>Address:</strong> {{ $product->address }}</p>
                                                            <p><strong>Location:</strong> {{ $product->latitude }}, {{ $product->longitude }}</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach


                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $products->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>

@endpush
