<?php

namespace HelthjemSDK\SingleAddressCheck;

use HelthjemSDK\Authentication\AuthTokenResponse;
use HelthjemSDK\Shared\Interfaces\Configuration;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use HelthjemSDK\SingleAddressCheck\ValueObjects\Address;

class SingleAddressCheckRequest extends GuzzleRequest
{
    protected $method = 'POST';
    protected $uri;
    protected $headers = [
        'Content-Type' => 'application/json'
    ];
    protected $body = null;

    /**
     * @param AuthTokenResponse $token
     * @param Configuration $configuration
     * @param $address
     */
    public function __construct(AuthTokenResponse $token, Configuration $configuration, Address $address)
    {
        $this->uri = $configuration->getBaseUri() . 'addressCheck/single/v-1/find';
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
