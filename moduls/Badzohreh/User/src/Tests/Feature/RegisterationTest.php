<?php

namespace moduls\Badzoreh\User\Tests\Feature;

use Badzohreh\RolePermissions\Database\Seeds\RolePermissionTableSeeder;
use Badzohreh\User\Models\User;
use Badzohreh\User\Services\VerifyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterationTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    private function registerNewUser()
    {
        return $this->post(route('register'), [
            'name' => 'mohammad',
            'email' => 'badzohreee222@gmail.com',
            'mobile' => '9113252367',
            'password' => 'Aa12!@',
            'password_confirmation' => 'Aa12!@'
        ]);
    }

    public function test_user_can_see_register_page()
    {
        $response = $this->get("/register");
        $response->assertStatus(200);
    }

    public function test_user_can_register()
    {
        $response = $this->registerNewUser();
        $response->assertRedirect(route('home'));
        $this->assertCount(1, User::all());
    }


    public function test_user_can_verify()
    {
        $user = User::create([
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'password' => bcrypt('aA1!!23'),
        ]);

        $code = VerifyService::generate();

        VerifyService::store($user->id, $code,now()->addDay());

        auth()->loginUsingId($user->id);

        $this->assertAuthenticated();

        $response = $this->post(route('verification.verify'), [
            'verification_code' => $code
        ]);

        $response->assertRedirect(route('home'));

        $this->assertEquals(true, $user->fresh()->hasVerifiedEmail());

    }

    public function test_have_to_verify_account()
    {
        $this->registerNewUser();
        $response = $this->get(route("home"));
        $response->assertRedirect(route('verification.notice'));
    }

    public function test_verfied_user_can_see_home_page()
    {
        $this->seed(RolePermissionTableSeeder::class);
        $this->registerNewUser();
        auth()->user()->markEmailAsVerified();
        $this->assertAuthenticated();
        $response = $this->get(route("home"));
        $response->assertOk();
    }


}
