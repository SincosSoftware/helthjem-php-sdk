<?php

namespace HelthjemSDK\NearbyServicepoint;

use HelthjemSDK\Authentication\AuthTokenResponse;
use HelthjemSDK\NearbyServicepoint\ValueObjects\Address;
use HelthjemSDK\Shared\Interfaces\Configuration;
use GuzzleHttp\Psr7\Request as GuzzleRequest;

class NearbyServicepointRequest extends GuzzleRequest
{
    protected $method = 'POST';
    protected $uri;
    protected $headers = [
        'Content-Type' => 'application/json'
    ];
    protected $body = null;


    /**
     * NearbyServicepointRequest constructor.
     * @param AuthTokenResponse $token
     * @param Configuration $configuration
     * @param Address $address
     * @throws \HelthjemSDK\Shared\Exceptions\HelthjemAuthenticationException
     */
    public function __construct(AuthTokenResponse $token, Configuration $configuration, Address $address)
    {
        $this->uri = $configuration->getBaseUri() . 'freightcoverage/v-1/servicepoints';
        $this->headers = array_merge($this->headers, $token->toHeader());

        $this->body = json_encode(array_merge([
            'shopId' => $configuration->getShopId(),
            'transportSolutionId' => $configuration->getTransportSolutionId(),
        ], $address->toArray()));

        return parent::__construct(
            $this->method,
            $this->uri,
            $this->headers,
            $this->body
        );
    }
}
