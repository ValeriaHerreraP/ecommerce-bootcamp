<?php

namespace App\Actions\ReportActions;


class ProductsCreateByMonth
{
    public static function execute(): array
    {
        $chart_options = [
            'chart_title' => 'PRODUCTS CREATED FOR MONTH',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Product',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'chart_type' => 'bar',
            'filter_field' => 'created_at',
            'filter_period' => 'year',
            'chart_color' => '106, 90, 205'
            ];

            return $chart_options;
        }
}

