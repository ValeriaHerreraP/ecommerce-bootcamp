<?php

namespace App\Actions\ReportActions;

class SalesByMonth
{
    public static function execute(): array
    {
        $chart_options = [
            'chart_title' => 'VENTAS POR MES EN PESOS',
            'chart_type' => 'line',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Payment',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'price_sum',
           'filter_period' => 'week',
           'chart_color' => '106, 90, 205'
        ];

        return $chart_options;
    }
}