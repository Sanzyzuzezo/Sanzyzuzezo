<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Orders;
use App\Models\OrderItems;
use App\Models\Stock;
use App\Models\Warehouse;
use App\Models\Promotion;
use Illuminate\Support\Facades\Auth;
use DataTables;
use DB;

class DashboardController extends Controller
{
    private static $module = "dashboard";
    public function index()
        {
            $user = Auth::user();
            $query_notification = Product::select('products.name AS product_name', 'product_variants.name AS variant_name','products.description AS deskripsi_Produk','product_variants.description AS deskripsi_variant','data_file AS image','stock.stock AS stock')
                    ->leftJoin('product_variants', 'product_variants.product_id', '=', 'products.id')
                    ->leftJoin('product_medias', 'product_medias.product_id', '=', 'products.id')
                    ->leftJoin('stock', 'product_variants.id', '=', 'stock.item_variant_id')
                    ->whereRaw("CAST(stock.stock AS INTEGER) < CAST(product_variants.minimal_stock AS INTEGER)");

            if ($user->company_id !== 0) {
                $query_notification->where('products.company_id', $user->company_id);
            }
            $notification = $query_notification->get();

            $query_hot = Product::select('products.name AS product_name', 'product_variants.name AS variant_name','products.description AS deskripsi_Produk','product_variants.description AS deskripsi_variant','data_file AS image','stock.stock AS stock')
                    ->leftJoin('product_variants', 'product_variants.product_id', '=', 'products.id')
                    ->leftJoin('stock', 'product_variants.id', '=', 'stock.item_variant_id')
                    ->leftJoin('product_medias', 'product_medias.product_id', '=', 'products.id')
                    ->leftJoin('order_items', 'order_items.product_id', '=', 'products.id')
                    ->leftJoin('orders', 'order_items.order_id', '=', 'orders.id')
                    ->where("orders.status", "paid")
                    ->orderBy('order_items.quantity', 'desc')
                    ->limit(1);

            if ($user->company_id !== 0) {
                $query_hot->where('products.company_id', $user->company_id);
            }
            $hot = $query_hot->get();

            $stock_warehouse = Stock::selectRaw('warehouses.name AS warehouse, SUM(CAST(stock.stock AS INTEGER)) AS total_stock')
                    ->leftJoin('warehouses', 'stock.warehouse_id', '=', 'warehouses.id')
                    ->groupBy(['stock.warehouse_id',"warehouses.name"])
                    ->get();

            $query_totalOrders = Orders::selectRaw('COUNT(orders.id) AS id_count')
                    ->where('orders.status', 'paid')
                    ->whereDate('orders.transaction_date', today());

            if ($user->company_id !== 0) {
                $query_totalOrders->where('orders.company_id', $user->company_id);
            }
            $totalOrders = $query_totalOrders->first();

            $query_totalOrders1 = Orders::selectRaw('SUM(orders.total) AS total')
                    ->where('orders.status', 'paid')
                    ->whereDate('orders.transaction_date', today());

            if ($user->company_id !== 0) {
                $query_totalOrders1->where('orders.company_id', $user->company_id);
            }
            $totalOrders1 = $query_totalOrders1->first();

            $query_totalOrdersItems = OrderItems::selectRaw('SUM(order_items.quantity) AS quantity')
                    ->leftJoin('orders', 'order_items.order_id', '=', 'orders.id')
                    ->where('orders.status', 'paid')
                    ->whereDate('orders.transaction_date', today());

            if ($user->company_id !== 0) {
                $query_totalOrdersItems->where('orders.company_id', $user->company_id);
            }
            $totalOrdersItems = $query_totalOrdersItems->first();

            $endDate = now()->addDay(1);
            $startDate = now()->subDays(6);

            $query_customer = Orders::selectRaw('COUNT(orders.id) AS id_count, customers.name AS customer, SUM(orders.total) AS total')
                    ->leftJoin('customers', 'orders.customer_id', '=', 'customers.id')
                    ->where('orders.status', 'paid')
                    ->whereDate('orders.transaction_date', '>=', $startDate)
                    ->whereDate('orders.transaction_date', '<=', $endDate)
                    ->groupBy('customers.id')
                    ->orderBy('id_count', 'desc')
                    ->limit(3);

            if ($user->company_id !== 0) {
                $query_customer->where('customers.company_id', $user->company_id);
            }
            $customer = $query_customer->get();

            $end = now()->addDay(3);

            $query_promotion = Promotion::selectRaw('promotions.type AS type, promotions.title AS title, promotions.start_date AS start_date, promotions.end_date AS end_date, promotions.note AS note')
                    ->where('promotions.end_date', '>=', now())
                    ->whereDate('promotions.end_date', '<=', $end)
                    ->orderBy('end_date', 'asc')
                    ->limit(3);

            if ($user->company_id !== 0) {
                $query_promotion->where('promotions.company_id', $user->company_id);
            }
            $promotion = $query_promotion->get();
                
            $query_promotion1 = Promotion::selectRaw('promotions.type AS type, promotions.title AS title, promotions.start_date AS start_date, promotions.end_date AS end_date, promotions.note AS note')
                    ->where('promotions.end_date', '>=', now())
                    ->orderBy('end_date', 'asc')
                    ->limit(3);

            if ($user->company_id !== 0) {
                $query_promotion1->where('promotions.company_id', $user->company_id);
            }
            $promotion1 = $query_promotion1->get();
                    
            $startDate = now()->startOfYear();
            $endDate = now()->endOfYear();
                

            $endDate = now()->addDay(1);
            $startDate = now()->subDays(6);
        
            $query_totalOrdersItems1 = Orders::selectRaw('COUNT(DISTINCT orders.id) AS id_count, EXTRACT(YEAR FROM orders.transaction_date) AS year, EXTRACT(MONTH FROM orders.transaction_date) AS month, SUM(orders.total) AS total, SUM(oi.quantity) AS quantity')
            ->leftJoin(DB::raw('(SELECT o.id AS order_id, SUM(oi.quantity) AS quantity FROM orders o LEFT JOIN order_items oi ON o.id = oi.order_id GROUP BY o.id) oi'), 'oi.order_id', '=', 'orders.id')
            ->where('orders.status', 'paid')
            ->whereBetween('orders.transaction_date', [$startDate, $endDate])
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc');

            if ($user->company_id !== 0) {
                $query_totalOrdersItems1->where('orders.company_id', $user->company_id);
            }
            $totalOrdersItems1 = $query_totalOrdersItems1->get();
            
            $results = [];
            
            for ($month = 1; $month <= 12; $month++) {
                $dataFound = $totalOrdersItems1->first(function ($item) use ($month) {
                    return $item->month == $month;
                });
            
                if ($dataFound) {
                    $results[] = $dataFound;
                } else {
                    $results[] = (object)['year' => now()->year, 'month' => $month, 'id_count' => 0];
                }
            }

      return view('administrator.dashboard', compact('notification','hot','stock_warehouse','totalOrders','totalOrders1','totalOrdersItems','results','customer','promotion','promotion1','user'));
    }

    public function getReportBuying () {
            $user = Auth::user();
            $endDate = now()->addDay(1);
            $startDate = now()->subDays(6);
            $query =  $customer = Orders::selectRaw('COUNT(orders.id) AS id_count, customers.name AS customer, SUM(orders.total) AS total',)
            ->leftJoin('customers', 'orders.customer_id', '=', 'customers.id')
            ->where('orders.status', 'paid')
            ->whereDate('orders.transaction_date', '>=', $startDate)
            ->whereDate('orders.transaction_date', '<=', $endDate)
            ->groupBy('customers.id')
            ->orderBy('id_count', 'desc')
            ->limit(5);

            if ($user->company_id !== 0) {
                $query->where('orders.company_id', $user->company_id);
            }
            $data = $query->get();
            // dd($data);

            return DataTables::of($data)
                ->addIndexColumn()
                ->rawColumns(['customer','id_count','total'])
                ->make(true);
    }

    public function getChartBuying(Request $request) {
        $user = Auth::user();
        if($request->input('waktu') == 'minggu') {
            $endDate = now()->addDay(1);
            $startDate = now()->subDays(6);
            $query_totalOrdersItems2 = Orders::selectRaw('COUNT(DISTINCT orders.id) AS id_count, EXTRACT(YEAR FROM orders.transaction_date) AS year, EXTRACT(MONTH FROM orders.transaction_date) AS month, EXTRACT(DAY FROM orders.transaction_date) AS day, SUM(orders.total) AS total, SUM(oi.quantity) AS quantity')
            ->leftJoin(DB::raw('(SELECT o.id AS order_id, SUM(oi.quantity) AS quantity FROM orders o LEFT JOIN order_items oi ON o.id = oi.order_id GROUP BY o.id) oi'), 'oi.order_id', '=', 'orders.id')
            ->where('orders.status', 'paid')
            ->whereDate('orders.transaction_date', '>=', $startDate)
            ->whereDate('orders.transaction_date', '<=', $endDate)
            ->groupBy('year', 'month', 'day')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->orderBy('day', 'desc');

            if ($user->company_id !== 0) {
                $query_totalOrdersItems2->where('orders.company_id', $user->company_id);
            }
            $totalOrdersItems2 = $query_totalOrdersItems2->get();
      
              $result = [];
              $currentDate = clone $startDate; // Gunakan clone untuk menghindari perubahan tanggal asli
      
              while ($currentDate <= $endDate) {
                  $formattedYear = $currentDate->year;
                  $formattedMonth = $currentDate->month;
                  $formattedDay = $currentDate->day;
      
                  $dataFound = $totalOrdersItems2->first(function ($item) use ($formattedYear, $formattedMonth, $formattedDay) {
                      return $item->year == $formattedYear && $item->month == $formattedMonth && $item->day == $formattedDay;
                  });
      
                  if ($dataFound) {
                      $result[] = $dataFound;
                  } else {
                      $result[] = (object)[
                          'year' => $formattedYear,
                          'month' => $formattedMonth,
                          'day' => $formattedDay,
                          'id_count' => 0
                      ];
                  }
      
                  $currentDate->addDay();
              }
            return response()->json(['data' => $result]);
        }

        else if($request->input('waktu') == 'bulan') {
            $startDate = now()->startOfMonth();
            $endDate = now()->endOfMonth();
    
            $query_totalOrdersItems3 = Orders::selectRaw('COUNT(DISTINCT orders.id) AS id_count, DATE_TRUNC(\'day\', orders.transaction_date) AS date, SUM(orders.total) AS total, SUM(oi.quantity) AS quantity')
            ->leftJoin(DB::raw('(SELECT o.id AS order_id, SUM(oi.quantity) AS quantity FROM orders o LEFT JOIN order_items oi ON o.id = oi.order_id GROUP BY o.id) oi'), 'oi.order_id', '=', 'orders.id')
            ->where('orders.status', 'paid')
            ->whereBetween('orders.transaction_date', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date', 'desc');
            
            if ($user->company_id !== 0) {
                $query_totalOrdersItems3->where('orders.company_id', $user->company_id);
            }
            $totalOrdersItems3 = $query_totalOrdersItems3->get();
    
            $results = [];
    
            for ($date = 1; $date <= 31; $date++) {
                $dataFound = $totalOrdersItems3->first(function ($item) use ($date) {
                    return $item->date == $date;
                });
    
                if ($dataFound) {
                    $results[] = $dataFound;
                } else {
                    $results[] = (object)['year' => now()->year, 'month' => now()->month, 'date' => $date, 'id_count' => 0];
                }
            }
            return response()->json(['data' => $results]);
        }

        else if($request->input('waktu') == 'tahun') {
            $startDate = now()->startOfYear();
            $endDate = now()->endOfYear();
            
            $query_totalOrdersItems1 = Orders::selectRaw('COUNT(DISTINCT orders.id) AS id_count, EXTRACT(YEAR FROM orders.transaction_date) AS year, EXTRACT(MONTH FROM orders.transaction_date) AS month, SUM(orders.total) AS total, SUM(oi.quantity) AS quantity')
            ->leftJoin(DB::raw('(SELECT o.id AS order_id, SUM(oi.quantity) AS quantity FROM orders o LEFT JOIN order_items oi ON o.id = oi.order_id GROUP BY o.id) oi'), 'oi.order_id', '=', 'orders.id')
            ->where('orders.status', 'paid')
            ->whereBetween('orders.transaction_date', [$startDate, $endDate])
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc');

            if ($user->company_id !== 0) {
                $query_totalOrdersItems1->where('orders.company_id', $user->company_id);
            }
            $totalOrdersItems1 = $query_totalOrdersItems1->get();
            
            $results = [];
            
            for ($month = 1; $month <= 12; $month++) {
                $dataFound = $totalOrdersItems1->first(function ($item) use ($month) {
                    return $item->month == $month;
                });
            
                if ($dataFound) {
                    $results[] = $dataFound;
                } else {
                    $results[] = (object)['year' => now()->year, 'month' => $month, 'id_count' => 0];
                }
            }
            return response()->json(['data' => $results]);
        }
    }
}
