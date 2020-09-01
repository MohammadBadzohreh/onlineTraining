<?php

namespace Tests\Unit;

use Badzohreh\User\Rules\ValidMobile;
use PHPUnit\Framework\TestCase;

class ValidMobileTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_mobile_should_start_with_9()
    {
        $validMobile = (new ValidMobile())->passes('', '6112356789');
        $this->assertEquals(0, $validMobile);
    }
    public function test_mobile_not_more_than_10_characters()
    {
        $validMobile = (new ValidMobile())->passes('', '91123678902');
        $this->assertEquals(0, $validMobile);
    }

    public function test_mobile_not_less_than_10_characters()
    {
        $validMobile = (new ValidMobile())->passes('', '911345678');
        $this->assertEquals(0, $validMobile);
    }
    public function test_mobile_should_be_numeric_characters()
    {
        $validMobile = (new ValidMobile())->passes('', '9122erfgtr');
        $this->assertEquals(0, $validMobile);
    }

}
