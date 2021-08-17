<?php

namespace HelthjemSDK\Authentication;

use HelthjemSDK\Shared\BaseRequest;
use HelthjemSDK\Shared\Exceptions\HelthjemApiRequestException;
use HelthjemSDK\Shared\Interfaces\Configuration;
use Carbon\Carbon;

class AuthTokenRequest extends BaseRequest
{
    protected $method = 'POST';
    protected $uri;
    protected $expires;
    protected $headers = [
        'Content-Type' => 'application/json'
    ];
    protected $body = null;
    public $validUntil;

    /**
     * @param Configuration $configuration
     * @param string $lifeTimeInMinutes
     * @throws HelthjemApiRequestException
     */
    public function __construct(Configuration $configuration, $lifeTimeInMinutes = '1440')
    {
        if (!is_int((int) $lifeTimeInMinutes) || (int) $lifeTimeInMinutes > 1440 || (int) $lifeTimeInMinutes < 1) {
            throw new HelthjemApiRequestException('Tokens an must have a lifetime between 1 - 1440');
        }

        $this->validUntil = Carbon::now()->addMinutes($lifeTimeInMinutes);
        $this->uri = $this->getBaseUri($configuration->isProduction()) . 'auth/v-3/login/'. $lifeTimeInMinutes;

        $this->body = json_encode([
            'username' => $configuration->getUserName(),
            'password' => $configuration->getPassword()
        ]);

        parent::__construct(
            $this->method,
            $this->uri,
            $this->headers,
            $this->body
        );
    }
}
