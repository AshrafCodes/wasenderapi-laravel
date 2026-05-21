<?php

namespace AshrafCodes\WasenderApi\Resources;

use AshrafCodes\WasenderApi\Client;

abstract class AbstractResource
{
    public function __construct(protected Client $client)
    {
    }
}
