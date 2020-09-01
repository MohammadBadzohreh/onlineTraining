<?php

namespace moduls\Badzoreh\User\Tests\Unit;

use Badzohreh\User\Rules\ValidPassword;
use PHPUnit\Framework\TestCase;

class ValidPasswordTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */


    public function test_password_not_be_less_6()
    {
        $validPassword = (new ValidPassword())->passes('', '!aA2f');
        $this->assertEquals(0, $validPassword);
    }

    public function test_password_must_have_upperCase_characers()
    {
        $validPassword = (new ValidPassword())->passes('','ass12!sdd');
        $this->assertEquals(0, $validPassword);
    }

    public function test_password_must_have_lowerCase_characers()
    {
        $validPassword = (new ValidPassword())->passes('','AADDMCD12!!!');
        $this->assertEquals(0, $validPassword);
    }


    public function test_password_must_have_digigt_characers()
    {
        $validPassword = (new ValidPassword())->passes('','AADDMCDaaa!!!');
        $this->assertEquals(0, $validPassword);
    }

    public function test_password_must_have_sign_characers()
    {
        $validPassword = (new ValidPassword())->passes('','AAD1233CDaaa');
        $this->assertEquals(0, $validPassword);
    }

}
