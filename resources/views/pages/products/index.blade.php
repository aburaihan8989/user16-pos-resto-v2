@extends('layouts.app')

@section('title', 'Products')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Products</h1>
                <div class="section-header-button">
                    @if ( auth()->user()->roles == "admin" )
                        <a href="{{ route('product.create') }}" class="btn btn-primary">Add New</a>
                    @else
                        <a href="#" class="btn btn-secondary">Add New</a>
                    @endif
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('product.index') }}">Products</a></div>
                    <div class="breadcrumb-item">All Products</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <h2 class="section-title">Products</h2>
                <p class="section-lead">
                    You can manage all Products, such as editing, deleting and more.
                </p>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>All Products</h4>
                            </div>
                            <div class="card-body">
                                {{-- <div class="float-left">
                                    <select class="form-control selectric">
                                        <option>Action For Selected</option>
                                        <option>Move to Draft</option>
                                        <option>Move to Pending</option>
                                        <option>Delete Pemanently</option>
                                    </select>
                                </div> --}}
                                <div class="float-right">
                                    <form method="GET" action="{{ route('product.index') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search Name" name="name">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Category</th>
                                            <th>Cost Price</th>
                                            <th>Sell Price</th>
                                            <th>Standar Stock</th>
                                            <th>Actual Stock</th>
                                            <th>Status Stock</th>
                                            <th>Photo</th>
                                            {{-- <th>Created At</th> --}}
                                            <th>Action</th>
                                        </tr>
                                        <?php $no = 1; ?>
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>
                                                    {{ $loop->iteration + $products->firstItem() - 1 }}
                                                </td>
                                                <td>
                                                    {{ $product->name }}
                                                </td>
                                                <td>
                                                    {{-- {{ $product->category }} --}}
                                                    @if ($product->category == 'minuman')
                                                        Minuman
                                                    @elseif ($product->category == 'makanan')
                                                        Makanan
                                                    @elseif ($product->category == 'other')
                                                        Other
                                                    @endif
                                                </td>
                                                <td>
                                                    Rp. {{ number_format(($product->cost_price), 0, ",", ".") }}
                                                </td>
                                                <td>
                                                    Rp. {{ number_format(($product->price), 0, ",", ".") }}
                                                </td>
                                                <td align="center">
                                                    {{ $product->std_stock }}
                                                </td>
                                                <td align="center">
                                                    {{ $product->stock }}
                                                </td>
                                                <td>
                                                    @if ($product->stock <= 0)
                                                        <span class="badge badge-danger">Habis</span>
                                                    @elseif ($product->stock > 0 & $product->stock < $product->std_stock)
                                                        <span class="badge badge-warning">Kurang</span>
                                                    @elseif ($product->stock > $product->std_stock)
                                                        <span class="badge badge-success">Banyak</span>
                                                    @else
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($product->image)
                                                        <img src="{{ asset('storage/products/'.$product->image) }}" alt=""
                                                            width="100px" class="img-thumbnail">
                                                            @else
                                                            <span class="badge badge-danger">No Image</span>
                                                    @endif
                                                </td>
                                                {{-- <td>
                                                    {{ $product->created_at }}
                                                </td> --}}
                                                <td>
                                                    <div class="d-flex">
                                                        @if ( auth()->user()->roles == "admin" )
                                                            <a href='{{ route('product.edit', $product->id) }}'
                                                                class="btn btn-sm btn-info btn-icon">
                                                                <i class="fas fa-edit"></i>
                                                                Edit
                                                            </a>
                                                        @else
                                                            <a href='#'
                                                                class="btn btn-sm btn-secondary btn-icon">
                                                                <i class="fas fa-edit"></i>
                                                                Edit
                                                            </a>
                                                        @endif

                                                        <form action="#">
                                                        {{-- <form action="{{ route('product.destroy', $product->id) }}"
                                                            method="POST" class="ml-2"> --}}
                                                            {{-- <input type="hidden" name="_method" value="DELETE" />
                                                            <input type="hidden" name="_token"
                                                                value="{{ csrf_token() }}" /> --}}
                                                            <button class="btn btn-sm btn-secondary btn-icon confirm-delete ml-2">
                                                                <i class="fas fa-times"></i> Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php $no++; ?>
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
