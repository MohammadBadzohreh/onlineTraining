<?php

namespace moduls\Badzoreh\User\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_user_can_see_reset_password_request()
    {
        $response = $this->get(route("password.request"));
        $response->assertOk();
    }


    public function test_user_can_see_verify_code_by_current_email()
    {
        $response = $this->call("get", route("password.sendVerifyCodeEmail"), [
            'email' => "badzohreee@gmail.com",
        ]);
        $response->assertOk();
    }


    public function test_user_reset_password_by_wrong_email()
    {
        $response = $this->call("get", route("password.sendVerifyCodeEmail"), [
            'email' => 'sss.com'
        ]);
        $response->assertRedirect();
    }


    public function test_user_banned_after_6_attemp()
    {
        for ($i = 1; $i <= 5; $i++) {
            $this->post(route("reset.password.check"),
                ["email" => "badzohreeee@gmail.com",
                    "verification_code" => "eee",
                ])->assertRedirect();
        }
        $this->post(route("reset.password.check"), [
            "email" => "badzohreeee@gmail.com",
            "verification_code" => "eee",
        ])->assertStatus(429);

    }
}
