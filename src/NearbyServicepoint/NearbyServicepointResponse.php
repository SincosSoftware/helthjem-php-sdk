<?php

namespace HelthjemSDK\NearbyServicepoint;

use HelthjemSDK\Shared\Traits\NonNullValueObject;

class NearbyServicepointResponse
{
    use NonNullValueObject;

    protected $freightProducts = [];

    public function __construct(array $data)
    {
        $this->fill($data);
    }
}
