<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_users_redirect_when_user_not_authenticated()
    {
        $response = $this->get(route('users.index'));

        $response->assertRedirectToRoute('login');
    }

    public function test_list_users_rol_not_authorize()
    {
        $customer = User::factory()->create();
        $role = Role::findOrCreate('customer');
        $customer->assignRole($role);
        $this->actingAs($customer);

        $response = $this->get(route('users.index'));

        $response
        ->assertForbidden();
    }

    public function test_list_users()
    {
        $users = User::factory(10)->create();

        $super_admin = User::factory()->create();
        $permission = Permission::findOrCreate('users.index');
        $role = Role::findOrCreate('super_admin')->givePermissionTo($permission);
        $super_admin->assignRole($role);

        $this->actingAs($super_admin);

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
        $super_admin = User::factory()->create();
        $permission = Permission::findOrCreate('users.index');
        $role = Role::findOrCreate('super_admin')->givePermissionTo($permission);
        $super_admin->assignRole($role);

        $this->actingAs($super_admin);

        $user = User::factory()->create();

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
        $super_admin = User::factory()->create();
        $permission = Permission::findOrCreate('users.edit');
        $role = Role::findOrCreate('super_admin')->givePermissionTo($permission);
        $super_admin->assignRole($role);

        $this->actingAs($super_admin);

        $user = User::factory()->create();

        $response = $this->get(route('users.edit', $user));

        $response
            ->assertViewIs('users.edit')
            ->assertOk()
            ->assertSee($user->name)
            ->assertSee($user->lastname, )
            ->assertSee($user->phone, )
            ->assertSee($user->email, );
    }

    public function test_update_user()
    {
        $super_admin = User::factory()->create();
        $permission = Permission::findOrCreate('users.edit');
        $role = Role::findOrCreate('super_admin')->givePermissionTo($permission);
        $super_admin->assignRole($role);

        $this->actingAs($super_admin);

        $user = User::factory()->create();

        $data = [
            'name' => fake()->firstname(),
            'lastname' => fake()->lastname(),
            'phone' => '4567822',
            'email' => fake()->unique()->safeEmail(),
        ];

        $response = $this->put(route('users.update', $user), $data);

        $response
            ->assertRedirectToRoute('users.index');

        $this->assertDatabaseHas('users', $data);
    }

    public function test_update_state_enable()
    {
        $super_admin = User::factory()->create();
        $permission = Permission::findOrCreate('users.updateStateEnable');
        $role = Role::findOrCreate('super_admin')->givePermissionTo($permission);
        $super_admin->assignRole($role);

        $this->actingAs($super_admin);

        $user = User::factory()->create();

        $data = ['state' => 0];

        $response = $this->put(route('users.updateStateEnable', $user), $data);

        $response
            ->assertRedirectToRoute('users.index');
        $this->assertDatabaseHas('users', $data);
    }

    public function test_update_state_user_disable()
    {
        $super_admin = User::factory()->create();
        $permission = Permission::findOrCreate('users.updateStateDisable');
        $role = Role::findOrCreate('super_admin')->givePermissionTo($permission);
        $super_admin->assignRole($role);

        $this->actingAs($super_admin);

        $user = User::factory()->create();

        $data = ['state' => 1];

        $response = $this->put(route('users.updateStateDisable', $user), $data);

        $response
            ->assertRedirectToRoute('users.index');
        $this->assertDatabaseHas('users', $data);
    }

    public function test_delete_user()
    {
        $super_admin = User::factory()->create();
        $permission = Permission::findOrCreate('users.destroy');
        $role = Role::findOrCreate('super_admin')->givePermissionTo($permission);
        $super_admin->assignRole($role);

        $this->actingAs($super_admin);

        $user = User::factory()->create();

        $response = $this->delete(route('users.destroy', $user));

        $response->assertStatus(302);
        $response->assertRedirect(route('users.index'));
    }
}
