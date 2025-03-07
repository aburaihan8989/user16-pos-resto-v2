<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index(Request $request)
    {
        //get data products
        $products = DB::table('stocks')
            ->when($request->input('transaction_time'), function ($query, $transaction_time) {
                return $query->where('transaction_time', 'like', '%' . $transaction_time . '%');
            })
            ->select('products.name as nama','stocks.transaction_time','stocks.total_price','stocks.quantity','users.name')
            ->leftJoin('products', 'stocks.product_id', '=', 'products.id')
            ->leftJoin('users', 'stocks.user_id', '=', 'users.id')
            ->where('type',0)
            ->orderBy('stocks.created_at', 'desc')
            ->paginate(10);
        //sort by created_at desc

        return view('pages.stock.index', compact('products'));
    }

    public function create()
    {
        return view('pages.stock.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $product = \App\Models\Product::where('id',$data['product_id'])->first();
        $data['total_price'] = $product->cost_price * $data['quantity'];
        $data['type'] = 0;
        $data['user_id'] = auth()->user()->id;
        \App\Models\Stock::create($data);
        $product->stock = $product->stock + $data['quantity'];
        $product->save();

        return redirect()->route('stock.index')->with('success', 'User successfully created');
    }

    public function index2(Request $request)
    {
        //get data products
        $products = DB::table('stocks')
            ->when($request->input('transaction_time'), function ($query, $transaction_time) {
                return $query->where('transaction_time', 'like', '%' . $transaction_time . '%');
            })
            ->select('products.name as nama','stocks.transaction_time','stocks.total_price','stocks.quantity','users.name')
            ->leftJoin('products', 'stocks.product_id', '=', 'products.id')
            ->leftJoin('users', 'stocks.kasir_id', '=', 'users.id')
            ->where('type',1)
            ->orderBy('stocks.created_at', 'desc')
            ->paginate(10);
        //sort by created_at desc

        return view('pages.stock.index2', compact('products'));
    }

    public function create2()
    {
        return view('pages.stock.create2');
    }

    public function store2(Request $request)
    {
        $data = $request->all();
        $product = \App\Models\Product::where('id',$data['product_id'])->first();
        $data['total_price'] = $product->cost_price * $data['quantity'];
        $data['type'] = 1;
        $data['user_id'] = auth()->user()->id;
        \App\Models\Stock::create($data);
        $product->stock = $product->stock - $data['quantity'];
        $product->save();

        return redirect()->route('stock-out')->with('success', 'User successfully created');
    }

    public function edit()
    {
        //
    }

    public function update()
    {
        //
    }

    public function destroy()
    {
        //
    }
}
