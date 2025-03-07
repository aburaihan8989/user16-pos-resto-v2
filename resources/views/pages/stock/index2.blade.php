@extends('layouts.app')

@section('title', 'Stocks Keluar')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Stocks Keluar</h1>
                <div class="section-header-button">
                    @if ( auth()->user()->roles == "admin" )
                        <a href="{{ route('stock-out-create') }}" class="btn btn-primary">Add Stock Keluar</a>
                    @else
                        <a href="#" class="btn btn-secondary">Add Stock Keluar</a>
                    @endif
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('stock-out') }}">Stocks Keluar</a></div>
                    <div class="breadcrumb-item">Stocks Keluar</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <h2 class="section-title">Stocks Keluar</h2>
                <p class="section-lead">
                    You can add Outgoing Stocks, view history stocks and more.
                </p>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Stocks Keluar</h4>
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
                                    <form method="GET" action="{{ route('stock-out') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search Name" name="transaction_time">
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
                                            <th>Transaction Time</th>
                                            <th>Name</th>
                                            <th>Quantity</th>
                                            <th>Total Price</th>
                                            <th>Kasir Gerobak</th>
                                            <th>Action</th>
                                        </tr>
                                        <?php $no = 1; ?>
                                        @foreach ($products as $data)
                                            <tr>
                                                <td>
                                                    {{ $loop->iteration + $products->firstItem() - 1 }}
                                                </td>
                                                <td>
                                                    {{ $data->transaction_time }}
                                                </td>
                                                <td>
                                                    {{ $data->nama }}
                                                </td>
                                                <td>
                                                    {{ $data->quantity }}
                                                </td>
                                                <td>
                                                    Rp. {{ number_format(($data->total_price), 0, ",", ".") }}
                                                </td>
                                                <td>
                                                    {{ $data->name }}
                                                </td>
                                                {{-- <td>
                                                    @if ($product->image)
                                                        <img src="{{ asset('storage/products/'.$product->image) }}" alt=""
                                                            width="100px" class="img-thumbnail">
                                                            @else
                                                            <span class="badge badge-danger">No Image</span>
                                                    @endif
                                                </td> --}}
                                                {{-- <td>
                                                    {{ $product->created_at }}
                                                </td> --}}
                                                <td>
                                                    <div class="d-flex">
                                                        @if ( auth()->user()->roles == "admin" )
                                                            {{-- <a href='{{ route('product.edit', $product->id) }}'
                                                                class="btn btn-sm btn-info btn-icon">
                                                                <i class="fas fa-edit"></i>
                                                                Edit
                                                            </a> --}}
                                                            <a href='#'
                                                                class="btn btn-sm btn-secondary btn-icon">
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
