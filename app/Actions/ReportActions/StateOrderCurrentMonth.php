<?php

namespace App\Actions\ReportActions;

class StateOrderCurrentMonth
{
    public static function execute(): array
    {
        $chart_options = [
            'chart_title' => 'ORDER STATUS',
            'chart_type' => 'bar',
            'report_type' => 'group_by_string',
            'model' => 'App\Models\Payment',
            'top_results' => 3,
            'group_by_field' => 'status',
            'group_by_period' => 'day',
            'filter_field' => 'created_at',
            'filter_period' => 'month',
            'chart_color' => '106, 90, 205',

        ];

        return $chart_options;
    }
}
