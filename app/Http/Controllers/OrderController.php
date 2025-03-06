<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //index
    public function index(Request $request)
    {
        // $orders = \App\Models\Order::with('kasir')->orderBy('transaction_time', 'desc')->paginate(10);

        //get data orders
        $orders = DB::table('orders')
        ->when($request->input('transaction_time'), function ($query, $transaction_time) {
            return $query->where('transaction_time', 'like', '%' . $transaction_time . '%');
        })
        ->select('orders.id as order_id','orders.*','users.*')
        ->leftJoin('users', 'orders.kasir_id', '=', 'users.id')
        ->orderBy('transaction_time', 'desc')
        ->paginate(10);
        //sort by transaction_time desc

        return view('pages.orders.index', compact('orders'));
    }

    //view
    public function show($id)
    {
        $order = \App\Models\Order::with('kasir')->findOrFail($id);
        $kasir = \App\Models\User::where('id', $order->kasir_id)->first();

        //get order items by order id
        $orderItems = \App\Models\OrderItem::with('product')->where('order_id', $id)->get();
        $orderSum = \App\Models\OrderItem::where('order_id', $id)->select(DB::raw('SUM(quantity * total_price) as total'))->value('total');

        return view('pages.orders.view', compact('order', 'kasir', 'orderItems', 'orderSum'));
    }
}
