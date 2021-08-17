<?php

namespace HelthjemSDK\Shared;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use HelthjemSDK\Authentication\AuthTokenResponse;
use HelthjemSDK\NearbyServicepoint\NearbyServicepointResponse;
use HelthjemSDK\Shared\Exceptions\HelthjemApiRequestException;
use HelthjemSDK\SingleAddressCheck\SingleAddressCheckResponse;
use Psr\Http\Message\RequestInterface;


class RequestHandler
{
    protected $client;
    protected $requestType;
    protected $response = [];

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param RequestInterface $request
     * @return AuthTokenResponse|NearbyServicepointResponse|SingleAddressCheckResponse
     * @throws Exceptions\HelthjemApiResponseException
     * @throws HelthjemApiRequestException
     */
    public function send(RequestInterface $request)
    {
        $this->requestType = get_class($request);

        try {
            $response = $this->client->send($request);
        } catch (GuzzleException $exception) {
            throw new HelthjemApiRequestException($exception->getMessage(), 500, $exception);
        }

        return ResponseHandler::handle($request, $response);
    }
}
