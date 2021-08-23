<?php

namespace HelthjemSDK\Shared;

use Exception;
use Psr\Http\Message\ResponseInterface;
use HelthjemSDK\Shared\Interfaces\Request;
use HelthjemSDK\Authentication\AuthToken;
use HelthjemSDK\Authentication\AuthTokenRequest;
use HelthjemSDK\SingleAddressCheck\SingleAddressCheckRequest;
use HelthjemSDK\SingleAddressCheck\SingleAddressCheckResponse;
use HelthjemSDK\NearbyServicepoint\NearbyServicepointRequest;
use HelthjemSDK\NearbyServicepoint\NearbyServicepointResponse;
use HelthjemSDK\Shared\Exceptions\HelthjemApiResponseException;

class ResponseHandler
{
    private $response;
    /**
     * @var Request
     */

    /**
     * ResponseHandler constructor.
     * @param BaseRequest $request
     * @param ResponseInterface $response
     * @throws HelthjemApiResponseException
     */
    private function __construct(BaseRequest $request, ResponseInterface $response)
    {
        try {
            $responseBody = json_decode((string) $response->getBody(), true);
        } catch (Exception $exception) {
            throw new HelthjemApiResponseException('Unexpected helthjemApi exception response: ' . get_class($request), 500, $exception);
        }

        switch (get_class($request)) {
            case AuthTokenRequest::class:
                /** @var AuthTokenRequest $request */
                $this->response = new AuthToken($responseBody['token'], $request->getValidUntil());
                break;
            case SingleAddressCheckRequest::class:
                $this->response = new SingleAddressCheckResponse($responseBody);
                break;
            case NearbyServicepointRequest::class:
                $this->response = new NearbyServicepointResponse($responseBody);
                break;
            default:
                throw new HelthjemApiResponseException('Unhandled helthjemApi response: ' . get_class($request));
        }
    }

    /**
     * @param BaseRequest $request
     * @param ResponseInterface $response
     * @return AuthToken|SingleAddressCheckResponse|NearbyServicepointResponse
     * @throws HelthjemApiResponseException
     */
    public static function handle(BaseRequest $request, ResponseInterface $response)
    {
        $handler = new static($request, $response);
        return $handler->getResponse();
    }


    public function getResponse()
    {
        return $this->response;
    }

}
