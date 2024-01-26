<?php

namespace Tests;

use Techamz\Generator\TechamzGeneratorServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            TechamzGeneratorServiceProvider::class,
        ];
    }
}
