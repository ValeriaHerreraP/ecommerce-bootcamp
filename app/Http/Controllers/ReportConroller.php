<?php

namespace App\Http\Controllers;

use App\Actions\ReportActions\OrderCreatedByMonth;
use App\Actions\ReportActions\ProductsCreateByMonth;
use App\Actions\ReportActions\ProductsSoldByMonth;
use App\Actions\ReportActions\SalesByMonth;
use App\Actions\ReportActions\StateOrderCurrentMonth;
use App\Actions\ReportActions\Top3UserCurrentMonth;
use App\Actions\ReportActions\TopProductsCurrentMonth;
use App\Actions\ReportActions\UserForMonth;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use Illuminate\Contracts\View\View;


class ReportConroller extends Controller
{
    public function index(): View
    {
        $user_for_month =  UserForMonth::execute();
        $chart1 = new LaravelChart($user_for_month);

        $products_sold_by_month =  ProductsSoldByMonth::execute();
        $chart3 = new LaravelChart($products_sold_by_month);
    
        $report_sales_by_month = SalesByMonth::execute();
        $chart2 = new LaravelChart($report_sales_by_month);
    
        /*
        $chart_options = [
                'chart_title' => 'Users by name products',
                'report_type' => 'group_by_string',
                'model' => 'App\Models\Product',
                'group_by_field' => 'product',
                'chart_type' => 'pie',
                'filter_field' => 'created_at',
                'filter_period' => 'month',
                'chart_color' => '106, 90, 205'
        
        ];

        $chart4 = new LaravelChart($chart_options);*/

        $products_create_by_month = ProductsCreateByMonth::execute();
        $chart5 = new LaravelChart($products_create_by_month );

        $order_create_by_month = OrderCreatedByMonth::execute();
        $chart6 = new LaravelChart($order_create_by_month);

        return view('reports.general', compact('chart1', 'chart2','chart3', 'chart5', 'chart6'));
    }
    
    public function detailed_report_for_the_current_month(): View
    {
        $top_prodruct_current_month = TopProductsCurrentMonth::execute();
        $chart3 = new LaravelChart($top_prodruct_current_month);

     
        $top3_user = Top3UserCurrentMonth::execute();
        $chart5 = new LaravelChart($top3_user);


        $state_order = StateOrderCurrentMonth::execute();
        $chart6 = new LaravelChart($state_order);

        return view('reports.DetailMonth', compact('chart3', 'chart5', 'chart6'));

    }

    
}
