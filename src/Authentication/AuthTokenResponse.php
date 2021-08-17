<?php

namespace HelthjemSDK\Authentication;

use Carbon\Carbon;
use HelthjemSDK\Shared\Exceptions\HelthjemAuthenticationException;
use HelthjemSDK\Shared\Traits\NonNullValueObject;

class AuthTokenResponse
{
    use NonNullValueObject;

    private $token;
    public $validUntil;

    public function __construct($token, Carbon $validUntil)
    {
        $this->token = $token;
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
