<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class LoggingTest extends TestCase
{
    //membuat log dengan log facade
    public function testLogging()
    {
        Log::info("Hello Info");
        Log::warning("Hello Warning");
        Log::error("Hello Error");
        Log::critical("Hello Critical");

        self::assertTrue(true);
    }

    public function testContext()
    {
        //Menggunakan context pada log facade
        Log::info("Hello Info", ["user" => "Restu"]);
        Log::info("Hello Info", ["user" => "Restu"]);
        Log::info("Hello Info", ["user" => "Restu"]);

        self::assertTrue(true);
    }

    public function testWithContext()
    {
        //Menggunakan withcontext pada log facade
        Log::withContext(["user" => "Restu"]);

        Log::info("Hello Info");
        Log::info("Hello Info");
        Log::info("Hello Info");

        self::assertTrue(true);
    }

    public function testChannel()
    {
        //embuat log dengan selected channel
        $slackLogger = Log::channel("slack"); //Mengirim ke channel yang telah ditentukan
        $slackLogger->error("Hello Slack"); // /Mengirim ke channel yang telah ditentukan

        Log::info("Hello Laravel"); // /Mengirim ke  default channel
        self::assertTrue(true);
    }

    public function testFileHandler()
    {
        //Melaakukan test pada channel yang dibuat
        $fileLogger = Log::channel("file");
        $fileLogger->info("Hello File Handler");
        $fileLogger->warning("Hello File Handler");
        $fileLogger->error("Hello File Handler");
        $fileLogger->critical("Hello File Handler");

        self::assertTrue(true);
    }


}
