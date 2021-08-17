<?php

namespace HelthjemSDK\Shared;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use HelthjemSDK\Authentication\AuthTokenResponse;
use HelthjemSDK\Shared\Exceptions\HelthjemApiRequestException;
use HelthjemSDK\SingleAddressCheck\SingleAddressCheckResponse;
use Psr\Http\Message\RequestInterface;

/**
 * Class Client
 * @package HelthjemSDK\Shared
 */
class Client
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
