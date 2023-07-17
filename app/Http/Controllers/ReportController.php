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
use App\Exports\ProductsDownloadExport;
use App\Exports\ProductsExport;
use App\Imports\ProductsExportforImport;
use App\Imports\ProductsImport;
use App\Loggers\Logger;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function export_import()
    {
        return view('reports.ExportImport');
    }

    public function export_download()
    {
        return Excel::download(new ProductsDownloadExport, 'downloadProducts.xlsx');
    }

    public function export_products_queue(): RedirectResponse
    {
        (new ProductsExport)->queue('products'.now()->format('Y-m-d-His').'.xlsx', 'disk_reports');
        Logger::export_products_admin();

        return redirect()->route('products.index')->with('messag', 'The export is in process');
    }

    public function import_products_queue(Request $request): RedirectResponse
    {
        if ($file = $request->file('doc')) {
            Excel::import(new ProductsImport, $file);
            Logger::import_products_admin();

            return redirect()->route('products.index')->with('message', 'Importation is in process');
        }

        return redirect()->route('products.index')->with('message', 'Attach an excel file');
    }

    public function import_products_queue_and_delete(Request $request): RedirectResponse
    {
        if ($file = $request->file('import')) {
            Excel::import(new ProductsExportforImport, $file);
            Logger::delete_and_import_products_admin();
            Product::query()->delete();

            return redirect()->route('products.index')->with('mess', 'Importation is in process');
        }

        return redirect()->route('products.index')->with('mess', 'Attach an excel file');
    }

    public function index(): View
    {
        $user_for_month = UserForMonth::execute();
        $chart1 = new LaravelChart($user_for_month);

        $products_sold_by_month = ProductsSoldByMonth::execute();
        $chart3 = new LaravelChart($products_sold_by_month);

        $report_sales_by_month = SalesByMonth::execute();
        $chart2 = new LaravelChart($report_sales_by_month);

        $products_create_by_month = ProductsCreateByMonth::execute();
        $chart5 = new LaravelChart($products_create_by_month);

        $order_create_by_month = OrderCreatedByMonth::execute();
        $chart6 = new LaravelChart($order_create_by_month);

        return view('reports.general', compact('chart1', 'chart2', 'chart3', 'chart5', 'chart6'));
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
