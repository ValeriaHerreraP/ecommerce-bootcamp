<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithChunkReading, ShouldQueue, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Product([

         'product' => $row['name'],
         'price' => $row['price'],
         'description' => $row['description'],
         'image' => $row['image'],
         'state' => $row['state'],

        ]);
    }

    public function chunkSize(): int
    {
        return 10;
    }
}
