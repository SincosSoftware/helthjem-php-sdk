<?php

namespace HelthjemSDK\Shared;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use HelthjemSDK\Shared\Exceptions\HelthjemApiResponseException;
use HelthjemSDK\Authentication\AuthToken;
use HelthjemSDK\NearbyServicepoint\NearbyServicepointResponse;
use HelthjemSDK\SingleAddressCheck\SingleAddressCheckResponse;


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
     * @param BaseRequest $request
     * @return AuthToken|NearbyServicepointResponse|SingleAddressCheckResponse
     * @throws Exceptions\HelthjemApiResponseException
     * @throws HelthjemApiResponseException
     */
    public function send(BaseRequest $request)
    {
        $this->requestType = get_class($request);

        try {
            $response = $this->client->send($request);
        } catch (GuzzleException $exception) {
            throw new HelthjemApiResponseException($exception->getMessage(), 500, $exception);
        }

        return ResponseHandler::handle($request, $response);
    }
}
