<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoutingTest extends TestCase
{
    public function testGet()
    {
        $this->get('/alam')
            ->assertStatus(200)
            ->assertSeeText('Alam');
    }

    public function testRedirect()
    {
        //melakukan test pada redirect route
        $this->get('/youtube')
            ->assertRedirect('/alam');
    }

    public function testFallback()
    {
        //melakukan testing pada fallback route
        $this->get('/tidakada')
            ->assertSeeText('404 by Alam');

        $this->get('/tidakadalagi')
            ->assertSeeText('404 by Alam');

        $this->get('/ups')
            ->assertSeeText('404 by Alam');
    }

    public function testRouteParameter()
    {
        //melakukan testing pada route parameters
        $this->get('/products/1')
            ->assertSeeText('Product 1');

        $this->get('/products/2')
            ->assertSeeText('Product 2');

        $this->get('/products/1/items/XXX')
            ->assertSeeText("Product 1, Item XXX");

        $this->get('/products/2/items/YYY')
            ->assertSeeText("Product 2, Item YYY");
    }

    public function testRouteParameterRegex()
    {
        //melakukan test pada route parametes dengan regex
        $this->get('/categories/100')
            ->assertSeeText('Category 100');

        $this->get('/categories/alam')
            ->assertSeeText('404 by Alam');
    }

    public function testRouteParameterOptional()
    {
        //melakukan test route parameters optional
        $this->get('/users/alam')
            ->assertSeeText('User alam');

        $this->get('/users/')
            ->assertSeeText('User 404');
    }

    public function testRouteConflict()
    {
        //melakukan test route parameters yang mengalami conflict
        $this->get('/conflict/budi')
            ->assertSeeText("Conflict budi");

        $this->get('/conflict/alam')
            ->assertSeeText("Conflict Alam");
    }

    public function testNamedRoute()
    {
        //melakukan test route parameters yang diberi nama
        $this->get('/produk/12345')
            ->assertSeeText('Link http://localhost/products/12345');

        $this->get('/produk-redirect/12345')
            ->assertRedirect('/products/12345');
    }


}
