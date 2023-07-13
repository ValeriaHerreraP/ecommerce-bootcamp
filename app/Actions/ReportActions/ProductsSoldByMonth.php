<?php

namespace App\Actions\ReportActions;


use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class ProductsSoldByMonth
{
    public static function execute(): array
    {
        $chart_options = [
            'chart_title' => 'CANTIDAD DE PRODUCTOS VENDIDOS POR MES',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\OrderDetail',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'chart_type' => 'bar',
            'filter_field' => 'created_at',
            'filter_period' => 'year',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'quantity',
            'chart_color' => '106, 90, 205'
            ];

            return $chart_options;
    }
}    