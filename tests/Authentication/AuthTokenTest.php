<?php

namespace Tests\Authentication;

use Carbon\Carbon;
use HelthjemSDK\Authentication\AuthToken;
use HelthjemSDK\Shared\Exceptions\HelthjemAuthenticationException;
use PHPUnit\Framework\TestCase;

final class AuthTokenTest extends TestCase
{

    public function testThrowsExceptionIfFetchingExpiredHeader()
    {
        $token = new AuthToken('test', Carbon::now()->subYear());
        $this->setExpectedException(HelthjemAuthenticationException::class);
        $token->toHeader();
    }

    public function testCanGetAuthorizationHeader()
    {
        $testToken = 'test';
        $response = new AuthToken($testToken, Carbon::now()->addMinutes(1440));
        $header = $response->toHeader();

        $this->assertCount(1, $header);
        $this->assertEquals('Authorization', array_keys($header)[0]);
        $this->assertEquals('Bearer ' . $testToken, array_values($header)[0]);
    }

    public function testDetectsIfTokenIsExpired()
    {
        $token = new AuthToken('test', Carbon::now()->subYear());
        $this->assertFalse($token->isValid());
    }

    public function testDetectsIfTokenIsValid()
    {
        $token = new AuthToken('test', Carbon::now()->addDay());
        $this->assertTrue($token->isValid());
    }
}
