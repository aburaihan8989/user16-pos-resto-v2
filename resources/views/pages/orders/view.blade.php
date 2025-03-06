@extends('layouts.app')

@section('title', 'Order Detail')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Order Detail</h1>

                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('order.index') }}">Orders</a></div>
                    <div class="breadcrumb-item">Order Detail</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <h2 class="section-title">Order Detail</h2>
                <p class="section-lead">
                {{-- <div>Total Price : Rp. {{ number_format(($orderSum), 0, ",", ".") }}</div>
                <div>Diskon : Rp. {{ number_format(($orderSum - $order->total_price), 0, ",", ".") }}</div>
                <div>Grand Total : Rp. {{ number_format(($order->total_price), 0, ",", ".") }}</div>
                <div>Transaction Time : {{ $order->transaction_time }}</div>
                <div>Total Item : {{ $order->total_item }}</div> --}}

                <div class="card col-4" id="card-transaction">
                    <div class="card-body pb-0">
                        <p class="text-muted">Detail Transaction</p>
                        <div class="form-group row mb-1">
                            <div class="col-sm-4">Transaction Time</div>
                            <div>: {{ $order->transaction_time }}</div>
                        </div>
                        <div class="form-group row mb-1">
                            <div class="col-sm-4">Total Price</div>
                            <div>: Rp. {{ number_format(($orderSum), 0, ",", ".") }}</div>
                        </div>
                        {{-- <div class="form-group row mb-1">
                            <div class="col-sm-4">Diskon</div>
                            <div>: Rp. {{ number_format(($orderSum - $order->total_price), 0, ",", ".") }}</div>
                        </div>
                        <div class="form-group row mb-1">
                            <div class="col-sm-4">Grand Total</div>
                            <div>: Rp. {{ number_format(($order->total_price), 0, ",", ".") }}</div>
                        </div> --}}
                        <div class="form-group row mb-1">
                            <div class="col-sm-4">Total Item</div>
                            <div>: {{ $order->total_item }}</div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4">Nama Kasir</div>
                            <div>: {{ $kasir->name }}</div>
                        </div>
                    </div>
                </div>

                </p>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>All Products</h4>
                            </div>
                            <div class="card-body">
                                <div class="clearfix mb-3"></div>
                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>
                                            <th>No</th>
                                            <th>Product Name</th>
                                            <th>Item Price</th>
                                            <th>Quantity</th>
                                            <th>Total Price</th>
                                        </tr>
                                        <?php $no = 1; ?>
                                        @foreach ($orderItems as $item)
                                            <tr>
                                                <td>
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td>
                                                    {{ $item->product->name }}
                                                </td>
                                                <td>
                                                    Rp. {{ number_format(($item->product->price), 0, ",", ".") }}
                                                </td>
                                                <td>
                                                    {{ $item->quantity }}
                                                </td>
                                                <td>
                                                    Rp. {{ number_format(($item->quantity * $item->total_price), 0, ",", ".") }}
                                                </td>
                                            </tr>
                                            <?php $no++; ?>
                                        @endforeach
                                    </table>
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
