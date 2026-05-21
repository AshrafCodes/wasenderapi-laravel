<?php

namespace Ashraf\WasenderApi\Resources;

use Ashraf\WasenderApi\Client;

abstract class AbstractResource
{
    public function __construct(protected Client $client)
    {
    }
}
