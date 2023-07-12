<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromQuery, WithHeadings
{
    use Exportable;
    /**
    * @return \Illuminate\Database\Eloquent\Builder;
    */
   /* public function collection()
    {
        return Product::all();
    }*/

    public function query(): Builder
    {
        return Product::query();
    }
     
    public function headings(): array
    {
        return [
            'id',
            'Name_product',
            'price',
            'description',
            'image',
            'state',
            'create_at',
            'updated_at',
        ];
    }
}
