<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConfigurationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testConfig()
    {
        $first = config('contoh.name.first');
        $email = config('contoh.Email');

        self::assertEquals('Alam', $first);
        self::assertEquals('restm41@gmail.com', $email);

    }
}
