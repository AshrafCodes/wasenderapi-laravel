<?php

namespace Ashraf\WasenderApi\Facades;

use Illuminate\Support\Facades\Facade;

class WasenderApi extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Ashraf\WasenderApi\WasenderApi::class;
    }
}
