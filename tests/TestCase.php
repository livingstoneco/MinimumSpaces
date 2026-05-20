<?php

declare(strict_types=1);

namespace MinimumSpaces\Tests;

use MinimumSpaces\MinimumSpacesServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /**
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function getPackageProviders($app): array
    {
        return [MinimumSpacesServiceProvider::class];
    }
}
