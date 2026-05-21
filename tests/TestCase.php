<?php

namespace AshrafCodes\WasenderApi\Tests;

use AshrafCodes\WasenderApi\WasenderApiServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [WasenderApiServiceProvider::class];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('wasenderapi.base_url', 'https://www.wasenderapi.com/api');
        $app['config']->set('wasenderapi.api_key', 'test-api-key');
        $app['config']->set('wasenderapi.personal_access_token', 'test-pat');
        $app['config']->set('wasenderapi.webhook_secret', 'secret');
    }
}
