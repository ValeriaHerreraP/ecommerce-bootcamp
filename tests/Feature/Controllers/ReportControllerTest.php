<?php

namespace Tests\Feature\Controllers;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsDownloadExport;
use App\Models\User;
use App\Models\Product;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Exports\ProductsExport;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use App\Imports\ProductsImport;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use Darryldecode\Cart\Facades\CartFacade as Cart;

class ReportControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_view_export_import_redirect_when_user_not_authenticated()
    {
        $response = $this->get(route('reports.ExportImport'));

        $response->assertRedirectToRoute('login');
    }

    public function test_export_not_download() 
    {
        Excel::fake();

        $customer = User::factory()->create();
        $role = Role::findOrCreate('customer');
        $customer->assignRole($role);

        $response = $this->actingAs($customer)
             ->get(route('products.exportdw'));
            
        $response
             ->assertForbidden();
    }

    public function test_export_download() 
    {
        Excel::fake();

        $super_admin = User::factory()->create();
        $permission = Permission::findOrCreate('products.export');
        $role = Role::findOrCreate('super_admin')->givePermissionTo($permission);
        $super_admin->assignRole($role);

        $this->actingAs($super_admin)
             ->get(route('products.exportdw'));

        Excel::assertDownloaded('downloadProducts.xlsx', function(ProductsDownloadExport $export) {
         
            return true;
        });

    }

    public function test_export_products_queue()
    {
        Excel::fake();
        Carbon::setTestNow(now());

        $super_admin = User::factory()->create();
        $permission = Permission::findOrCreate('products.export');
        $role = Role::findOrCreate('super_admin')->givePermissionTo($permission);
        $super_admin->assignRole($role);

       $response = $this->actingAs($super_admin)
             ->get(route('products.export'));
    
        Excel::assertQueued('products'. now()->format('Y-m-d-His'). '.xlsx', 'disk_reports');   
        
        Excel::assertQueued('products'. Carbon::now()->format('Y-m-d-His'). '.xlsx', 'disk_reports', function(ProductsExport $export) {
            return true;
        });

        $response 
        ->assertRedirectToRoute('products.index');
     
    }

/*
    public function test_user_can_import_users() 
    {
        $super_admin = User::factory()->create();
        $permission = Permission::findOrCreate('products.import');
        $role = Role::findOrCreate('super_admin')->givePermissionTo($permission);
        $super_admin->assignRole($role);

        $this->actingAs($super_admin)
        ->get(route('products.import'));   

        Excel::fake();

        $file = UploadedFile::fake()->create('products.xlsx', 100);

        Excel::assertQueued($file);
    
        Excel::assertQueued($file, function(ProductsImport $import) {
            return true;
        
        });
        
    }
    */


    public function test_index_super_admin_view_report_general()
    {
        $super_admin = User::factory()->create();
        $permission = Permission::findOrCreate('reports.general');
        $role = Role::findOrCreate('super_admin')->givePermissionTo($permission);
        $super_admin->assignRole($role);

        $data= [
           'chart_title' => 'ORDER CREATED FOR MONTH',
           'report_type' => 'group_by_date',
           'model' => 'App\Models\Payment',
           'group_by_field' => 'created_at',
           'group_by_period' => 'month',
           'chart_type' => 'line',
           'filter_field' => 'created_at',
           'filter_period' => 'year',
           'date_format_filter_days',
           'chart_color' => '106, 90, 205'
           ];

           $chart6 = new LaravelChart($data);

       $response = $this->actingAs($super_admin)
        ->get(route('reports.general', compact('chart6')));


             $response 
             ->assertViewIs('reports.general')
             ->assertSeeText('ORDER CREATED FOR MONTH')
             ->assertOk();
    }

    public function test_cant_view_detailed_report_for_the_current_month() 
    {

        $customer = User::factory()->create();
        $role = Role::findOrCreate('customer');
        $customer->assignRole($role);

        $response = $this->actingAs($customer)
             ->get(route('reports.DetailMonth'));
            
        $response
             ->assertForbidden();
    }

    public function test_detailed_report_for_the_current_month()
    {
        $super_admin = User::factory()->create();
        $permission = Permission::findOrCreate('reports.DetailMonth');
        $role = Role::findOrCreate('super_admin')->givePermissionTo($permission);
        $super_admin->assignRole($role);

        $data= [
            'chart_title' => 'USERS WITH THE MOST PURCHASES',
            'chart_type' => 'bar',
            'report_type' => 'group_by_string',
            'model' => 'App\Models\OrderDetail',
            'top_results' => 3,
            'group_by_field' => 'name',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'quantity',
            'filter_field' => 'created_at',
            'filter_period' => 'month', 
            'chart_color' => '106, 90, 205'
           ];

           $report = new LaravelChart($data);

       $response = $this->actingAs($super_admin)
        ->get(route('reports.DetailMonth', compact('report')));


             $response 
             ->assertViewIs('reports.DetailMonth')
             ->assertSeeText('USERS WITH THE MOST PURCHASES')
             ->assertOk();
    }

}