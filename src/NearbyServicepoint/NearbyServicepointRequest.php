<?php

namespace HelthjemSDK\NearbyServicepoint;

use HelthjemSDK\Authentication\AuthToken;
use HelthjemSDK\Shared\Interfaces\Address;
use HelthjemSDK\Shared\BaseRequest;
use HelthjemSDK\Shared\Exceptions\HelthjemAuthenticationException;
use HelthjemSDK\Shared\Interfaces\Configuration;

class NearbyServicepointRequest extends BaseRequest
{
    protected $method = 'POST';
    protected $uri;
    protected $headers = [
        'Content-Type' => 'application/json'
    ];
    protected $body = null;


    /**
     * NearbyServicepointRequest constructor.
     * @param AuthToken $token
     * @param Configuration $configuration
     * @param Address $address
     * @throws HelthjemAuthenticationException
     */
    public function __construct(AuthToken $token, Configuration $configuration, Address $address)
    {
        $this->uri = $this->getBaseUri($configuration->isProduction()) . 'freightcoverage/v-1/servicepoints';
        $this->headers = array_merge($this->headers, $token->toHeader());

        $this->body = json_encode([
            'shopId' => $configuration->getShopId(),
            'transportSolutionId' => $configuration->getTransportSolutionId(),
            'countryCode' => $address->getCountryCode(),
            'postalName' => $address->getCity(),
            'zipCode' => $address->getZipCode(),
            'streetAddress' => $address->getStreetAddress(),
            'coAddress' => $address->getCareOf()
        ]);

        return parent::__construct(
            $this->method,
            $this->uri,
            $this->headers,
            $this->body
        );
    }
}
