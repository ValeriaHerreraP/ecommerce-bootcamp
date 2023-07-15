<?php

namespace App\Actions\ReportActions;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class UserForMonth
{
    public static function execute(): array
    {
        $chart_options = [
            'chart_title' => 'USERS CREATED PER MONTH',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\User',
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