<?php

namespace moduls\Badzoreh\User\Tests\Feature;

use Badzohreh\User\Models\User;
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

    public function test_have_to_verify_account()
    {
        $this->registerNewUser();
        $response = $this->get(route("home"));
        $response->assertRedirect(route('verification.notice'));
    }

    public function test_verfied_user_can_see_home_page()
    {
        $this->registerNewUser();
        auth()->user()->markEmailAsVerified();
        $this->assertAuthenticated();
        $response = $this->get(route("home"));
        $response->assertOk();
    }



}
