<?php

namespace HelthjemSDK\Shared;

use GuzzleHttp\Psr7\Request as GuzzleRequest;

abstract class BaseRequest extends GuzzleRequest
{
    const STAGING_BASE_URI = 'https://api.pre.helthjem.no/';
    const PRODUCTION_BASE_URI = 'https://api.helthjem.no/';

    public function getBaseUri($isProduction = false)
    {
        return $isProduction ? static::PRODUCTION_BASE_URI : static::STAGING_BASE_URI;
    }
}
