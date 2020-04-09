<?php

namespace App\Http\Controllers;

use App\models\Brand;
use App\models\Category;
use App\models\Client;
use App\models\Product;
use App\models\ProductSale;
use App\models\Sale;
use App\Seller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function get_week()
    {
        $today  = Carbon::today();
        $last_week = Carbon::now()->subDays(7);
        return array($last_week, $today);
    }
    public function product_sale()
    {
        $product_sale = ProductSale::get('sale_id');
        $sale_id = [];
        foreach ($product_sale as $sale) {
            $sale_id[] = $sale->sale_id;
        }
        return $sale_id;
    }

    public function user_count()
    {
        return User::count();
    }
    public function clients_count()
    {
        return Client::count();
    }
    public function sellers_count()
    {
        return Seller::count();
    }
    public function total_sales_count()
    {
        return Sale::count();
    }

    public function product_count()
    {
        return Product::count();
    }

    public function category_count()
    {
        return Category::count();
    }

    public function brand_count()
    {
        return Brand::count();
    }

    public function week_total_sales_income()
    {
       return ProductSale::sum('total_price');
    }
    public function week_sold_items()
    {
        return ProductSale::whereBetween('created_at', $this->get_week())->count();
    }
    public function week_orders()
    {
        if (Auth::guard('seller')->check()) {
            $sale_id = $this->product_sale();
            return Sale::whereBetween('created_at', $this->get_week())->whereIn('id', $sale_id)->count();
        }
        return Sale::whereBetween('created_at', $this->get_week())->count();
    }

    public function week_sales_count()
    {
        $sales = new Sale();
        if (Auth::guard('seller')->check()) {
            $sale_id = $this->product_sale();
            $sales = $sales->whereIn('id', $sale_id);
        }
        $sales = $sales->whereBetween('created_at', $this->get_week())->where('status', 'Complete');
        return $sales->count();
    }
    // Charts

    public function sales_chart(Request $request)
    {
        $sales = Sale::withoutGlobalScopes()
            ->select(DB::raw('count(id) as count, date_format(created_at, "%M") as date'))
            ->orderBy('id', 'asc')
            ->groupBy('date');

        if (Auth::guard('seller')->check()) {
            $sale_id = $this->product_sale();
            $sales = $sales->whereIn('id', $sale_id);
        }
        // return $request->all();
        if ($request->year_f) {
            $sales = $sales->whereYear('created_at', '=', (int) $request->year_f);
        }
        $sales = $sales->get();
        $lables = [];
        $rows = [];
        foreach ($sales as $key => $sale) {
            $lables[] = $sale->date;
            $rows[] = $sale->count;
        }
        $data = array(
            'lables' => $lables,
            'rows' => $rows
        );
        return response()->json(['data' => $data]);
    }

    public function sellers_chart(Request $request)
    {
        // return $request->all();
        $sellers = Seller::withoutGlobalScopes()
            ->select(DB::raw('count(id) as count, date_format(created_at, "%M") as date'))
            ->orderBy('id', 'asc')
            ->groupBy('date');
        if ($request->year_f) {
            $sellers = $sellers->whereYear('created_at', '=', (int) $request->year_f);
        }
        $sellers = $sellers->get();
        $lables = [];
        $rows = [];
        foreach ($sellers as $key => $seller) {
            $lables[] = $seller->date;
            $rows[] = $seller->count;
        }
        $data = array(
            'lables' => $lables,
            'rows' => $rows
        );
        return response()->json(['data' => $data]);
    }
    public function clients_chart(Request $request)
    {
        // return $request->all();
        $schools = Client::withoutGlobalScopes()
            ->select(DB::raw('count(id) as count, date_format(created_at, "%M") as date'))
            ->orderBy('id', 'asc')
            ->groupBy('date');
        if ($request->year_f) {
            $schools = $schools->whereYear('created_at', '=', (int) $request->year_f);
        }
        $schools = $schools->get();
        $lables = [];
        $rows = [];
        foreach ($schools as $key => $school) {
            $lables[] = $school->date;
            $rows[] = $school->count;
        }
        $data = array(
            'lables' => $lables,
            'rows' => $rows
        );
        return response()->json(['data' => $data]);
    }
}
