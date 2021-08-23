<?php

namespace HelthjemSDK\Authentication;

use Carbon\Carbon;
use HelthjemSDK\Shared\Exceptions\HelthjemAuthenticationException;

class AuthToken
{
    private $token;
    private $validUntil;

    public function __construct($token, Carbon $validUntil)
    {
        $this->token = $token;
        $this->validUntil = $validUntil;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return !$this->validUntil->isPast();
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

}
