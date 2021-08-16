<?php

namespace HelthjemSDK\Authentication;

use Carbon\Carbon;
use HelthjemSDK\Shared\Exceptions\HelthjemAuthenticationException;
use HelthjemSDK\Shared\Traits\NonNullValueObject;

class AuthTokenResponse
{
    use NonNullValueObject;

    private $token;
    private $validUntil;

    public function __construct($authToken, Carbon $validUntil)
    {
        $this->token = $authToken;
        $this->validUntil = $validUntil;
    }

    /**
     * @return string[]
     * @throws HelthjemAuthenticationException
     */
    public function toHeader()
    {
        if (!$this->isValid()) {
            throw new HelthjemAuthenticationException('Authentication token has expired.');
        }
        return [
            'Authorization' => $this->toBearer()
        ];
    }

    protected function toBearer()
    {
        return 'Bearer ' . $this->token;
    }

    protected function isValid()
    {
        return !$this->validUntil->isPast();
    }
}
