<?php

namespace HelthjemSDK\Shared;

use GuzzleHttp\Psr7\Request as GuzzleRequest;

abstract class BaseRequest extends GuzzleRequest
{
    const STAGING_BASE_URI = 'https://staging-ws.di.no/ws/json/';
    const PRODUCTION_BASE_URI = 'https://ws.di.no/ws/json/';

    public function getBaseUri($isProduction = false)
    {
        return $isProduction ? static::PRODUCTION_BASE_URI : static::STAGING_BASE_URI;
    }
}
