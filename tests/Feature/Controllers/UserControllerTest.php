<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_list_users_redirect_when_user_not_authenticated()
    {
        $response = $this->get(route('users.index'));

        $response->assertRedirectToRoute('login');
    }

    public function test_list_users()
    {
        $users = User::factory(10)->create();
      
        $this->actingAs(User::factory()->create(['is_admin' => true]));

        $response = $this->get(route('users.index'));

        $user = $users->first();
        $response
            ->assertViewIs('users.index')
            ->assertOk()
            ->assertSeeText($user->name)
            ->assertSeeText($user->lastname)
            ->assertSeeText('Actualizar');    
    }
    
    public function test_list_users_with_search()
    {
        $user = User::factory()->create();
        $this->actingAs(User::factory()->create(['is_admin' => true]));

        $response = $this->get(route('users.index').'?search='.$user->name);

        $response
            ->assertViewIs('users.index')
            ->assertOk()
            ->assertSeeText($user->name)
            ->assertSeeText($user->lastname)
            ->assertSeeText('Actualizar');
    }

    public function test_edit_user()
    {
        $user = User::factory()->create();
        $this->actingAs(User::factory()->create(['is_admin' => true]));

        $response = $this->get(route('users.edit', $user));

        $response
            ->assertViewIs('users.edit')
            ->assertOk()
            ->assertSee($user->name)
            ->assertSee($user->lastname,)
            ->assertSee($user->phone,)
            ->assertSee($user->email,);
    }

    public function test_update_user()
    {
        $user = User::factory()->create();
        $this->actingAs(User::factory()->create(['is_admin' => true]));

        $data = [
            'name' => fake()->firstname(),
            'lastname' => fake()->lastname(),
            'phone' => "4567822",
            'email' => fake()->unique()->safeEmail(),
        ];

        $response = $this->put(route('users.update', $user), $data);

        $response
            ->assertRedirectToRoute('users.index');

        $this->assertDatabaseHas('users', $data);
    }


    public function test_update_state_enable()
    {
        $user = User::factory()->create();
        $this->actingAs(User::factory()->create(['is_admin' => true]));

        $data = [ 'state' => 0];

        $response = $this->put(route('users.updateStateEnable', $user), $data);

        $response
            ->assertRedirectToRoute('users.index');
            $this->assertDatabaseHas('users', $data);
       
    }

    public function test_update_state_product_disable()
    {
        $user = User::factory()->create();
        $this->actingAs(User::factory()->create(['is_admin' => true]));

        $data = [ 'state' => 1];
    
        $response = $this->put(route('users.updateStateDisable', $user), $data);

        $response
            ->assertRedirectToRoute('users.index');
            $this->assertDatabaseHas('users', $data);
       
    }
    public function test_delete_user()
    {
        $user = User::factory()->create();
        $this->actingAs(User::factory()->create(['is_admin' => true]));
    

        $response = $this->delete(route('users.destroy', $user));

        $response->assertStatus(302);
        $response->assertRedirect(route('users.index'));
    }
    
   
}

