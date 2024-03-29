<?php

namespace App\Actions\ReportActions;

class OrderCreatedByMonth
{
    public static function execute(): array
    {
        $chart_options = [
            'chart_title' => 'ORDER CREATED FOR MONTH',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Payment',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'chart_type' => 'line',
            'filter_field' => 'created_at',
            'filter_period' => 'year',
            'date_format_filter_days',
            'chart_color' => '106, 90, 205',
            ];

        return $chart_options;
    }
}
