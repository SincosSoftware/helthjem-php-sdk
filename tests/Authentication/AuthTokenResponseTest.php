<?php

namespace Tests\Authentication;

use Carbon\Carbon;
use HelthjemSDK\Authentication\AuthTokenResponse;
use HelthjemSDK\Shared\Exceptions\HelthjemAuthenticationException;
use PHPUnit\Framework\TestCase;

final class AuthTokenResponseTest extends TestCase
{

    public function testThrowsExceptionIfFetchingExpiredHeader()
    {
        $response = new AuthTokenResponse('test', Carbon::now()->subYear());
        $this->setExpectedException(HelthjemAuthenticationException::class);
        $response->toHeader();
    }

    public function testCanGetAuthorizationHeader()
    {
        $testToken = 'test';
        $response = new AuthTokenResponse($testToken, Carbon::now()->addMinutes(1440));
        $header = $response->toHeader();

        $this->assertCount(1, $header);
        $this->assertEquals('Authorization', array_keys($header)[0]);
        $this->assertEquals('Bearer ' . $testToken, array_values($header)[0]);
    }
}
