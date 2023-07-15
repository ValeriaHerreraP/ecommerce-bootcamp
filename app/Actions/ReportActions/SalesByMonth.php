<?php

namespace App\Actions\ReportActions;

class SalesByMonth
{
    public static function execute(): array
    {
        $chart_options = [
            'chart_title' => 'SALES PER MONTH IN PESOS',
            'chart_type' => 'line',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Payment',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'conditions'            => [
                ['name' => 'Completed', 'condition' => 'status = "COMPLETED"', 'color' => 'blue', 'fill' => true],
            ],
            'aggregate_function' => 'sum',
            'aggregate_field' => 'price_sum',
            'filter_period' => 'year',
            'chart_color' => '106, 90, 205'
        ];

        return $chart_options;
    }
}