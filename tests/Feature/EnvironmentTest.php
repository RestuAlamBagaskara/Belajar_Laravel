<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EnvironmentTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetEnv()
    {
        //mengaksesk nilai pada file .env
       $youtube = env('YOUTUBE');
       self::assertEquals('Programmer Zaman Now', $youtube);
    }
}
