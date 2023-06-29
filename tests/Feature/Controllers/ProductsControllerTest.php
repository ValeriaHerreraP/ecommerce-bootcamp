<?php

namespace Tests\Feature\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ProductsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_products_redirect_when_user_not_authenticated()
    {
        $response = $this->get(route('products.index'));

        $response->assertRedirectToRoute('login');
    }

    public function test_list_products()
    {
        $products = Product::factory(10)->create();
      
        $this->actingAs(User::factory()->create(['is_admin' => true]));

        $response = $this->get(route('products.index'));

        $products = $products->first();
        $response
            ->assertViewIs('products.index')
            ->assertOk()
            ->assertSeeText($products->product)
            ->assertSeeText($products->price)
            ->assertSeeText($products->description)
            ->assertSeeText('Edit')
            ->assertSeeText('Delete');  
              
    }

    public function test_create_product()
    {
        $product = Product::factory()->create();
        $this->actingAs(User::factory()->create(['is_admin' => true]));

        $response = $this->get(route('products.create',  $product));

        $response
            ->assertViewIs('products.create')
            ->assertOk()
            ->assertSeeText('Product')
            ->assertSeeText('Price')
            ->assertSeeText('Description');     
    }   

    public function test_store_product()
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]));

        Storage::fake('public');
        $file = UploadedFile::fake()->image('https://img.freepik.com/vector-premium/imagen-dibujos-animados-hongo-palabra-hongo_587001-200.jpg')->size(3500);

        $data = [
            'product' => fake()->name(),
            'price' => "30000",
            'description' => fake()->sentence(),
            'image' => $file,
        ];

        $response = $this->post(route('products.store'), $data);

        $response
            ->assertRedirectToRoute('products.index');

         //$this->assertDatabaseHas('products', $data);
    }
    

    public function test_edit_product()
    {
        $product = Product::factory()->create();
        $this->actingAs(User::factory()->create(['is_admin' => true]));

        $response = $this->get(route('products.edit', $product));

        $response
            ->assertViewIs('products.edit')
            ->assertOk()
            ->assertSee($product->product)
            ->assertSee($product->price,)
            ->assertSee($product->description);
           
    }

    public function test_update_product()
    {
        $product = Product::factory()->create();
        $this->actingAs(User::factory()->create(['is_admin' => true]));

       
        
        $data = [
            'product' => fake()->name(),
            'price' => "50000",
            'description' => fake()->sentence(),
            'image' => 'image\logo.jpg',
        ];

        $response = $this->put(route('products.update', $product), $data);

        $response
            ->assertRedirectToRoute('products.index');

         //$this->assertDatabaseHas('products', $data);
    }


    public function test_delete_product()
    {
        $product = Product::factory()->create();
        $this->actingAs(User::factory()->create(['is_admin' => true]));
    

        $response = $this->delete(route('products.destroy', $product));

        $response->assertStatus(302);
        $response->assertRedirect(route('products.index'));
    }
    


}
