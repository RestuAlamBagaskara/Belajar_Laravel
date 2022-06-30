<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HelloControllerTest extends TestCase
{
    public function testHello()
    {
        //melakukan test pada fungsi hello di HelloController
        $this->get('/controller/hello/Eko')
            ->assertSeeText("Halo Eko");
    }

    public function testRequest()
    {
        //melakukan test pada fungsi request di HelloController
        $this->get('/controller/hello/request', [
            "Accept" => "plain/text"
        ])->assertSeeText("controller/hello/request")
            ->assertSeeText("http://localhost/controller/hello/request")
            ->assertSeeText("GET")
            ->assertSeeText("plain/text");
    }


}
