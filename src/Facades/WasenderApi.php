<?php

namespace AshrafCodes\WasenderApi\Facades;

use Illuminate\Support\Facades\Facade;

class WasenderApi extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \AshrafCodes\WasenderApi\WasenderApi::class;
    }
}
