<?php

namespace App\Actions\ReportActions;

use PhpParser\Node\Stmt\Return_;

class TopProductsCurrentMonth
{
    public static function execute(): array
    {
        $chart_options = [
            'chart_title' => 'TOP 3 BEST SELLING PRODUCTS',
            'chart_type' => 'bar',
            'report_type' => 'group_by_string',
            'model' => 'App\Models\OrderDetail',
            'top_results' => 3,
            'group_by_field' => 'name',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'quantity',
            'filter_field' => 'created_at',
            'filter_period' => 'month',
            'chart_color' => '106, 90, 205',

        ];

        return $chart_options;
    }
}
