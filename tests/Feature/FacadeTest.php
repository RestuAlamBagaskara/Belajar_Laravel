<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class FacadeTest extends TestCase
{
    public function testConfig()
    {
        $firstName1 = config('contoh.author.first');
        $firstName2 = Config::get('contoh.author.first');

        self::assertEquals($firstName1, $firstName2);

        var_dump(Config::all());
    }

    public function testConfigDependency()
    {
        $config = $this->app->make('config');
        $firstName3 = $config->get('contoh.nama.first');

        $firstName1 = config('contoh.nama.first');
        $firstName2 = Config::get('contoh.nama.first');

        self::assertEquals($firstName1, $firstName2);
        self::assertEquals($firstName1, $firstName3);

        var_dump($config->all());
    }

    public function testFacadeMock()
    {
        Config::shouldReceive('get')
            ->with('contoh.nama.first')
            ->andReturn('Alam');

        $firstName = Config::get('contoh.nama.first');

        self::assertEquals('Alam', $firstName);
    }


}
