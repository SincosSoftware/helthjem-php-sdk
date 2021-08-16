<?php

namespace HelthjemSDK\Shared;

use HelthjemSDK\NearbyServicepoint\NearbyServicepointRequest;
use HelthjemSDK\NearbyServicepoint\NearbyServicepointResponse;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

use HelthjemSDK\Shared\Interfaces\Request;
use HelthjemSDK\Authentication\AuthTokenResponse;
use HelthjemSDK\Authentication\AuthTokenRequest;
use HelthjemSDK\SingleAddressCheck\SingleAddressCheckRequest;
use HelthjemSDK\SingleAddressCheck\SingleAddressCheckResponse;
use HelthjemSDK\Shared\Exceptions\HelthjemApiRequestException;
use HelthjemSDK\Shared\Exceptions\HelthjemApiResponseException;

class ResponseHandler
{
    private $request;
    private $response;

    const HTTP_OK = 200;
    /**
     * @var Request
     */

    /**
     * ResponseHandler constructor.
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @throws HelthjemApiRequestException
     * @throws HelthjemApiResponseException
     */
    private function __construct(RequestInterface $request, ResponseInterface $response)
    {
        $this->request = $request;
        $requestType = get_class($request);
        $responseBody = json_decode((string) $response->getBody(), true);

        if ($response->getStatusCode() !== static::HTTP_OK) {
            throw new HelthjemApiRequestException('Api request ' . $requestType . ' failed with status ' . $response->getStatusCode(), 424);
        }

        switch ($requestType) {
            case AuthTokenRequest::class:
                $this->response = new AuthTokenResponse($responseBody['token'], $request->validUntil);
                break;
            case SingleAddressCheckRequest::class:
                $this->response = new SingleAddressCheckResponse($responseBody);
                break;
            case NearbyServicepointRequest::class:
                $this->response = new NearbyServicepointResponse($responseBody);
                break;
            default:
                throw new HelthjemApiResponseException('Unhandled helthjemApi response: ' . $requestType);
        }
    }

    /**
     * @param Request $request
     * @param ResponseInterface $response
     * @return AuthTokenResponse|SingleAddressCheckResponse
     * @throws HelthjemApiRequestException
     * @throws HelthjemApiResponseException
     */
    public static function handle(RequestInterface $request, ResponseInterface $response)
    {
        $handler = new static($request, $response);
        return $handler->getResponse();
    }


    public function getResponse()
    {
        return $this->response;
    }

}
