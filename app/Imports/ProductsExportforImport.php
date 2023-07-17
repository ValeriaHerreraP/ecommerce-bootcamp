<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsExportforImport implements ToModel, WithChunkReading, ShouldQueue, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Product([
         'id' => $row['id'],
         'product' => $row['name'],
         'price' => $row['price'],
         'description' => $row['description'],
         'image' => $row['image'],
         'state' => $row['state'],
         'created_at' => $row['created_at'],
         'updated_at' => $row['updated_at'],
        ]);
    }

    public function chunkSize(): int
    {
        return 10;
    }
}
