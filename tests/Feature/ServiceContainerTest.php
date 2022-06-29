<?php

namespace Tests\Feature;

use App\Data\Bar;
use App\Data\Foo;
use App\Data\Person;
use App\Services\HelloService;
use App\Services\HelloServiceIndonesia;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServiceContainerTest extends TestCase
{
    public function testDependency()
    {
        $foo1 = $this->app->make(Foo::class); // new Foo()
        $foo2 = $this->app->make(Foo::class); // new Foo()

        self::assertEquals('Foo', $foo1->foo());
        self::assertEquals('Foo', $foo2->foo());
        self::assertNotSame($foo1, $foo2);
    }

    public function testBind()
    {
        // $person = $this->app->make(Person::class); // new Person()
        // self::assertNotNull($person);

        $this->app->bind(Person::class, function ($app){
            return new Person("Alam", "Bagas");
        });

        $person1 = $this->app->make(Person::class); // closure() //  new Person("Alam", "Bagas");
        $person2 = $this->app->make(Person::class); // closure() // new Person("Alam", "Bagas");

        self::assertEquals('Alam', $person1->firstName);
        self::assertEquals('Alam', $person2->firstName);
        self::assertNotSame($person1, $person2); //Harusnya menghasilkan True karena tidak sama
    }

    public function testSingleton()
    {
        $this->app->singleton(Person::class, function ($app){
            return new Person("Alam", "Bagas");
        });

        $person1 = $this->app->make(Person::class); // new Person("Alam", "Bagas"); if not exists
        $person2 = $this->app->make(Person::class); // return existing
        $person3 = $this->app->make(Person::class); // return existing
        $person4 = $this->app->make(Person::class); // return existing

        self::assertEquals('Alam', $person1->firstName);
        self::assertEquals('Alam', $person2->firstName);
        self::assertSame($person1, $person2); //Harusnya menghasilkan True karena sama
    }

    public function testInstance()
    {
        $person = new Person("Alam", "Bagas");
        //seperti singleton, tetapi menggunakan instance
        $this->app->instance(Person::class, $person);

        $person1 = $this->app->make(Person::class); // mengembalikan object $person
        $person2 = $this->app->make(Person::class); // mengembalikan object $person
        $person3 = $this->app->make(Person::class); //  mengembalikan object $person
        $person4 = $this->app->make(Person::class); //  mengembalikan object $person

        self::assertEquals('Alam', $person1->firstName);
        self::assertEquals('Alam', $person2->firstName);
        self::assertSame($person1, $person2);
    }

    public function testDependencyInjection()
    {
        //registrasi foo sebagai singleton
        $this->app->singleton(Foo::class, function ($app){
            return new Foo();
        });


        $this->app->singleton(Bar::class, function ($app){
            $foo = $app->make(Foo::class);
            return new Bar($foo);
        });

        $foo = $this->app->make(Foo::class);
        $bar1 = $this->app->make(Bar::class);
        $bar2 = $this->app->make(Bar::class);

        self::assertSame($foo, $bar1->foo);
        self::assertSame($bar1, $bar2);
    }

    public function testInterfaceToClass()
    {
        $this->app->singleton(HelloService::class, HelloServiceIndonesia::class);

        //untuk object yang lebih komplek
        // $this->app->singleton(HelloService::class, function ($app){
        //     return new HelloServiceIndonesia();
        // });

        $helloService = $this->app->make(HelloService::class);

        self::assertEquals('Halo Alam', $helloService->hello('Alam'));
    }
}
