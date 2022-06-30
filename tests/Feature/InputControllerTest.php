<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InputControllerTest extends TestCase
{
    public function testInput()
    {
        $this->get('/input/hello?name=Alam')
            ->assertSeeText('Hello Alam');

        $this->post('/input/hello', [
            'name' => 'Alam'
        ])->assertSeeText('Hello Alam');
    }

    public function testInputNested()
    {
        $this->post('/input/hello/first', [
            "name" => [
                "first" => "Alam",
                "last" => "Bagas"
            ]
        ])->assertSeeText("Hello Alam");
    }

    public function testInputAll()
    {
        $this->post('/input/hello/input', [
            "name" => [
                "first" => "Alam",
                "last" => "Bagas"
            ]
        ])->assertSeeText("name")->assertSeeText("first")
            ->assertSeeText("last")->assertSeeText("Alam")
            ->assertSeeText("Bagas");
    }

    //test array input
    public function testInputArray()
    {
        $this->post('/input/hello/array', [
            "products" => [
                [
                    "name" => "Asus",
                    "price" => 30000000
                ],
                [
                    "name" => "Xiaomi",
                    "price" => 15000000
                ]
            ]
        ])->assertSeeText("Asus")
            ->assertSeeText("Xiaomi");
    }

    //test input type
    public function testInputType()
    {
        $this->post('/input/type', [
            'name' => 'Budi',
            'married' => 'true',
            'birth_date' => '1990-10-10'
        ])->assertSeeText('Budi')->assertSeeText("true")->assertSeeText("1990-10-10");
    }

    //melakukan test pada filter only
    public function testFilterOnly()
    {
        $this->post('/input/filter/only', [
            "name" => [
                "first" => "Alam",
                "middle" => "Kurniawan",
                "last" => "Bagas"
            ]
        ])->assertSeeText("Alam")->assertSeeText("Bagas")
            ->assertDontSeeText("Kurniawan");
    }

    //melakukan test pada filter except
    public function testFilterExcept()
    {
        $this->post('/input/filter/except', [
            "username" => "Bagas",
            "password" => "rahasia",
            "admin" => "true"
        ])->assertSeeText("Bagas")->assertSeeText("rahasia")
            ->assertDontSeeText("admin");
    }


    public function testFilterMerge()
    {
        $this->post('/input/filter/merge', [
            "username" => "Bagas",
            "password" => "rahasia",
            "admin" => "true"
        ])->assertSeeText("Bagas")->assertSeeText("rahasia")
            ->assertSeeText("admin")->assertSeeText("false");
    }


}
