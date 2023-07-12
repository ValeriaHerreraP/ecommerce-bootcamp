<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class ReportConroller extends Controller
{
    public function index()
    {
        $chart_options = [
            'chart_title' => 'Users by months',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\User',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'chart_type' => 'bar',
            'filter_field' => 'created_at',
            'filter_days' => 60, 
            'chart_color' => '255,0,0'// show only last 30 days
        ];
    
        $chart1 = new LaravelChart($chart_options);
    
    
        $chart_options = [
            'chart_title' => 'Users by names',
            'report_type' => 'group_by_string',
            'model' => 'App\Models\User',
            'group_by_field' => 'name',
            'chart_type' => 'pie',
            'filter_field' => 'created_at',
            'filter_period' => 'month', // show users only registered this month
        ];
    
        $chart2 = new LaravelChart($chart_options);
    

        $chart_options = [
            'chart_title' => 'Top 3 productos mas vendido',
            'chart_type' => 'bar',
            'report_type' => 'group_by_string',
            'model' => 'App\Models\OrderDetail',
            //'conditions'            => [
                //['name' => 'Food', 'condition' => 'category_id = 1', 'color' => 'black', 'fill' => true],
                //['name' => 'Transport', 'condition' => 'category_id = 2', 'color' => 'blue', 'fill' => true],
           // ],
           'top_results' => 3,
            'group_by_field' => 'name',
            'group_by_period' => 'day',
        
            'aggregate_function' => 'sum',
            'aggregate_field' => 'quantity',
            
            //'filter_field' => 'transaction_date',
           // 'filter_days' => 30, // show only transactions for last 30 days
            'filter_period' => 'week', // show only transactions for this week
            //'continuous_time' => true, // show continuous timeline including dates without data
        ];

        $chart3 = new LaravelChart($chart_options);
        /*
        $chart_options = [
            'chart_title' => 'Users by name products',
            'report_type' => 'group_by_string',
            'model' => 'App\Models\Product',
            'group_by_field' => 'product',
            'chart_type' => 'pie',
            'filter_field' => 'created_at',
            'filter_period' => 'month',
        ];
    
        $chart3 = new LaravelChart($chart_options);
    
        
        */
        return view('graficos', compact('chart1', 'chart2', 'chart3'));
    }
    
}
