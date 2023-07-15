<?php

namespace Tests\Feature\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class ProductsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_products_redirect_when_user_not_authenticated()
    {
        $response = $this->get(route('products.index'));

        $response->assertRedirectToRoute('login');
    }

    public function test_list_products_rol_not_authotized()
    {
        $customer= User::factory()->create();
        $role = Role::findOrCreate('customer');
        $customer->assignRole($role);

        $this->actingAs($customer);

        $products = Product::factory(10)->create();

        $response = $this->get(route('products.index'));

        $products = $products->first();
        $response
            ->assertForbidden();
           
    }
    
    public function test_list_products()
    {
        $super_admin = User::factory()->create();
        $permission = Permission::findOrCreate('products.index');
        $role = Role::findOrCreate('super_admin')->givePermissionTo($permission);
        $super_admin->assignRole($role);

        $this->actingAs($super_admin);

        $products = Product::factory(10)->create();

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
        $super_admin = User::factory()->create();
        $permission = Permission::findOrCreate('products.create');
        $role = Role::findOrCreate('super_admin')->givePermissionTo($permission);
        $super_admin->assignRole($role);

        $this->actingAs($super_admin);

        $product = Product::factory()->create();

        $response = $this->get(route('products.create', $product));

        $response
            ->assertViewIs('products.create')
            ->assertOk()
            ->assertSeeText('Product')
            ->assertSeeText('Price')
            ->assertSeeText('Description');
    }

    public function test_store_product()
    {
        $super_admin = User::factory()->create();
        $permission = Permission::findOrCreate('products.create');
        $role = Role::findOrCreate('super_admin')->givePermissionTo($permission);
        $super_admin->assignRole($role);

        $this->actingAs($super_admin);

        Storage::fake('public');
        $file = UploadedFile::fake()->image('https://img.freepik.com/vector-premium/imagen-dibujos-animados-hongo-palabra-hongo_587001-200.jpg')->size(3500);

        $data = [
            'product' => fake()->name(),
            'price' => '30000',
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
        $super_admin = User::factory()->create();
        $permission = Permission::findOrCreate('products.edit');
        $role = Role::findOrCreate('super_admin')->givePermissionTo($permission);
        $super_admin->assignRole($role);

        $this->actingAs($super_admin);

        $product = Product::factory()->create();

        $response = $this->get(route('products.edit', $product));

        $response
            ->assertViewIs('products.edit')
            ->assertOk()
            ->assertSee($product->product)
            ->assertSee($product->price, )
            ->assertSee($product->description);
    }

    public function test_update_product()
    {
        $super_admin = User::factory()->create();
        $permission = Permission::findOrCreate('products.edit');
        $role = Role::findOrCreate('super_admin')->givePermissionTo($permission);
        $super_admin->assignRole($role);

        $this->actingAs($super_admin);

        $product = Product::factory()->create();

        $data = [
            'product' => fake()->name(),
            'price' => '50000',
            'description' => fake()->sentence(),
            'image' => 'image\logo.jpg',
        ];

        $response = $this->put(route('products.update', $product), $data);

        $response
            ->assertRedirectToRoute('products.index');

        //$this->assertDatabaseHas('products', $data);
    }

    public function test_update_state_product_enable()
    {
        $super_admin = User::factory()->create();
        $permission = Permission::findOrCreate('products.updateStateEnable');
        $role = Role::findOrCreate('super_admin')->givePermissionTo($permission);
        $super_admin->assignRole($role);

        $this->actingAs($super_admin);

        $product = Product::factory()->create();

        $data = ['state' => 0];

        $response = $this->put(route('products.updateStateEnable', $product), $data);

        $response
            ->assertRedirectToRoute('products.index');
        $this->assertDatabaseHas('products', $data);
    }

    public function test_update_state_product_disable()
    {
        $super_admin = User::factory()->create();
        $permission = Permission::findOrCreate('products.updateStateDisable');
        $role = Role::findOrCreate('super_admin')->givePermissionTo($permission);
        $super_admin->assignRole($role);

        $this->actingAs($super_admin);

        $product = Product::factory()->create();

        $data = ['state' => 1];

        $response = $this->put(route('products.updateStateDisable', $product), $data);

        $response
            ->assertRedirectToRoute('products.index');
        $this->assertDatabaseHas('products', $data);
    }

    public function test_delete_product()
    {
        $super_admin = User::factory()->create();
        $permission = Permission::findOrCreate('products.destroy');
        $role = Role::findOrCreate('super_admin')->givePermissionTo($permission);
        $super_admin->assignRole($role);

        $this->actingAs($super_admin);

        $product = Product::factory()->create();

        $response = $this->delete(route('products.destroy', $product));

        $response->assertStatus(302);
        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseMissing('products', [
            'product' => $product->product,
            'price' => $product->price,
            'description' => $product->description,
            'image'=> $product->image,
            'state' => $product->state,
        ]);
    }


}

