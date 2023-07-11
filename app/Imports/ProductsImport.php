<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ProductsImport implements ToModel, WithChunkReading, ShouldQueue
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
 
         'product' => $row[0],
         'price' => $row[1],
         'description' => $row[2],
         'image' => $row[3],
         'state' => $row[4],
         //'create_at' => $row[5],
         //'updated_at' => $row[6],

        ]);
    }

    public function chunkSize(): int
    {
        return 10;
    }
}
