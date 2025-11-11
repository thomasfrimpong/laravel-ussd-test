<?php

namespace Vendor\LaravelUssd\Tests\Unit;

use Vendor\LaravelUssd\Support\UssdResponse;
use Vendor\LaravelUssd\Tests\TestCase;

class UssdResponseTest extends TestCase
{
    public function test_continue_response_format(): void
    {
        $response = UssdResponse::continue('Please enter your PIN');

        $this->assertEquals('CON Please enter your PIN', (string) $response);
        $this->assertEquals('CON', $response->type);
        $this->assertEquals('Please enter your PIN', $response->message);
    }

    public function test_end_response_format(): void
    {
        $response = UssdResponse::end('Thank you for using our service');

        $this->assertEquals('END Thank you for using our service', (string) $response);
        $this->assertEquals('END', $response->type);
        $this->assertEquals('Thank you for using our service', $response->message);
    }
}

