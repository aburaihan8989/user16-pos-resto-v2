<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //index
    public function index() {
        $total_sales = Order::sum('total_price');
        $total_count = Order::count();

        $sales_today = Order::whereDate('transaction_time',date('Y-m-d'))->sum('total_price');
        $count_today = Order::whereDate('transaction_time',date('Y-m-d'))->count();

        $sales_before = Order::whereDate('transaction_time',date('Y-m-d',strtotime("yesterday")))->sum('total_price');
        $count_before = Order::whereDate('transaction_time',date('Y-m-d',strtotime("yesterday")))->count();

        $total_price = DB::table('order_items')
            ->leftJoin('products', 'order_items.product_id', '=', 'products.id')
            ->sum(DB::raw('order_items.quantity * products.price'));

        $total_cost = DB::table('order_items')
            ->leftJoin('products', 'order_items.product_id', '=', 'products.id')
            ->sum(DB::raw('order_items.quantity * products.cost_price'));

        $total_profit = $total_price - $total_cost;

        $bulan = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
        $sales_monthly = [];

        foreach ($bulan as $b) {
            $sales_monthly[] = Order::whereDate('transaction_time','like','%'.date('Y').'-'.$b.'%')->sum('total_price');
        }

        // $top_sales = OrderItem::select('product_id', DB::raw('SUM(quantity) as `count`'))
        // ->groupBy('product_id')
        // ->orderBy('count', 'DESC')
        // ->limit(5)->get();

        $top_sales = DB::table('order_items')
            ->leftJoin('products','products.id','=','order_items.product_id')
            ->select('products.name',
                DB::raw('SUM(order_items.quantity) as count'),
                DB::raw('SUM(order_items.quantity * products.price) as total'))
            ->groupBy('products.name')
            ->orderBy('count','desc')
            ->limit(5)
            ->get();

        $produk_kurang = DB::table('products')
            ->where('stock', '>', 0)
            ->whereColumn('stock', '<', 'std_stock')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        $produk_habis = DB::table('products')
            ->where('stock','<=',0)
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        $top_cabang = DB::table('order_items')
            ->leftJoin('orders','orders.id','=','order_items.order_id')
            ->leftJoin('users','users.id','=','orders.kasir_id')
            ->select('users.name',
                DB::raw('SUM(order_items.quantity) as count'),
                DB::raw('SUM(order_items.quantity * order_items.total_price) as total'))
            ->groupBy('users.name')
            ->orderBy('count','desc')
            ->limit(5)
            ->get();

        $month_cabang = DB::table('order_items')
            ->leftJoin('orders','orders.id','=','order_items.order_id')
            ->leftJoin('users','users.id','=','orders.kasir_id')
            ->select('users.name',
                DB::raw('SUM(order_items.quantity) as count'),
                DB::raw('SUM(order_items.quantity * order_items.total_price) as total'))
            ->whereDate('order_items.created_at',date('m'))
            ->groupBy('users.name')
            ->orderBy('count','desc')
            ->limit(5)
            ->get();


        return view('pages.dashboard', [
            'total_sales'     => $total_sales,
            'total_count'     => $total_count,
            'sales_today'     => $sales_today,
            'count_today'     => $count_today,
            'sales_before'    => $sales_before,
            'count_before'    => $count_before,
            'total_cost'      => $total_cost,
            'total_profit'    => $total_profit,
            'sales_monthly'   => $sales_monthly,
            'produk_kurang'   => $produk_kurang,
            'produk_habis'    => $produk_habis,
            'top_cabang'      => $top_cabang,
            'month_cabang'    => $month_cabang,
            'top_sales'       => $top_sales
        ]);
    }
}
