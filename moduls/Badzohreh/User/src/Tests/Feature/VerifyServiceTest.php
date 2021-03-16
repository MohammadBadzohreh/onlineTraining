<?php

namespace Badzohreh\User\Tests\Feature;

use Badzohreh\User\Services\VerifyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VerifyServiceTest extends TestCase
{
    public function test_generated_code_is_6_digits()
    {
        $code = VerifyService::generate();
        $this->assertIsNumeric($code, 'code is not numeric');
        $this->assertGreaterThanOrEqual(100000, $code, 'code is less than 100000');
        $this->assertLessThanOrEqual(999999, $code, 'code is more than 999999');
    }

    public function test_cache_can_store()
    {
        $code = VerifyService::generate();
        VerifyService::store(1, $code,now()->addDay());
        $this->assertEquals($code,cache()->get('verificaionCode1'));
    }
}
