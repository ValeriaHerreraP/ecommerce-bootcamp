<?php

namespace Tests\Feature\Controllers\Api;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ApiProductsControllerTest extends TestCase
{
    /*
    public function test_api_index()
    {
        Product::factory(20)->create();

        $this->getJson(route('api.products.index'))
            ->assertOk();
    }*/

    public function test_store_product_api()
    {
        /** @var Product $product */
        $product = Product::factory()->make();

        Storage::fake('public');
        $file = UploadedFile::fake()->image('images/logo.png');

        $this->postJson(route('api.products.store'), [
            'product' => $product->product,
            'price' => $product->price,
            'description' => $product->description,
            'image'=> $file,
            'state' => $product->state,
        ])->assertCreated()
            ->assertJson(function (AssertableJson $json) use ($product) {
                $json->where('message', 'The product was created successfully')
                    ->has('data', function (AssertableJson $data) use ($product) {
                        $data
                        ->where('name_product', $product->product)
                        ->has('price')
                        ->where('description', $product->description)
                        ->has('image')
                        ->where('state', $product->state);
                    });
            });

        $this->assertDatabaseHas('products', [
            'product' => $product->product,
            'price' => $product->price,
            'description' => $product->description,
            'state' => $product->state,
        ]);
    }

    public function test_show_api(): void
    {
        /** @var Product $product */
        $product = Product::factory()->create();

        $this->getJson(route('api.products.show', $product->id))
            ->assertOk()
            ->assertJson(function (AssertableJson $json) use ($product) {
                $json->has('data', function (AssertableJson $data) use ($product) {
                    $data
                        ->where('name_product', $product->product)
                        ->has('price')
                        ->where('description', $product->description)
                        ->where('image', $product->image)
                        ->has('state');
                });
            });
    }

    public function test_update_product_api()
    {
        /** @var Product $post */
        $product = Product::factory()->create();

        $this->putJson(route('api.products.update', $product->id), [
            'price' => '45789',
        ])->assertOk()
            ->assertJson(function (AssertableJson $json) {
                $json->where('message', 'The product was updated successfully');
            });

        $this->assertDatabaseHas('products', [
          'price' => '45789',
        ]);
    }

    public function test_can_destroy(): void
    {
        $product = Product::factory()->create();

        $this->deleteJson(route('api.products.destroy', $product))
            ->assertNoContent($status = 204);

        $this->assertDatabaseMissing('products', [
            'product' => $product->product,
            'price' => $product->price,
            'description' => $product->description,
            'image'=> $product->image,
            'state' => $product->state,
        ]);
    }
}
