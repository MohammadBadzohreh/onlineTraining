<?php

namespace Tests\Feature;

use Badzohreh\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use WithFaker;
    use RefreshDatabase;


    private function createNewUser()
    {
        return User::create([
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'mobile' => '9113457689',
            'password' => bcrypt('Aa12!1@'),
        ]);
    }

    public function test_user_can_see_login_page()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }


    public function test_user_can_login_by_email()
    {
        $user = $this->createNewUser();
        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'Aa12!1@',
        ]);
        $this->assertAuthenticated();
    }

    public function test_user_can_login_by_mobile()
    {
        $user = $this->createNewUser();
        $this->post(route('login'), [
            'email' => '9113457689',
            'password' => 'Aa12!1@',
        ]);
        $this->assertAuthenticated();
    }
}
