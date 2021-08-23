<?php

namespace Tests\Authentication;

use Carbon\Carbon;
use UnexpectedValueException;
use HelthjemSDK\Authentication\AuthTokenRequest;
use HelthjemSDK\Shared\Interfaces\Configuration;
use PHPUnit\Framework\TestCase;

final class AuthTokenRequestTest extends TestCase
{
    private $configuration;

    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->configuration = $this->getMock(Configuration::class);
        $this->configuration->method('getUserName')->willReturn('test');
        $this->configuration->method('getPassword')->willReturn('test');
        $this->configuration->method('isProduction')->willReturn(false);
        $this->configuration->method('getShopId')->willReturn(1);
        $this->configuration->method('getTransportSolutionId')->willReturn(1);
    }

    public function testThrowsExceptionIfLifetimeIsTooLong()
    {
        $this->setExpectedException(UnexpectedValueException::class);
        new AuthTokenRequest($this->configuration, 1500);
    }

    public function testThrowsExceptionIfLifetimeIsZero()
    {
        $this->setExpectedException(UnexpectedValueException::class);
        new AuthTokenRequest($this->configuration, 0);
    }

    public function testThrowsExceptionIfLifetimeIsNonNumeric()
    {
        $this->setExpectedException(UnexpectedValueException::class);
        new AuthTokenRequest($this->configuration, 'asd');
    }

    public function testCorrectValidityIsSet()
    {
        Carbon::setTestNow(Carbon::create(2000, 1, 1, 0));
        $request = new AuthTokenRequest($this->configuration, '1440');
        $this->assertEquals(Carbon::create(2000, 1, 1, 0)->addMinutes(1440), $request->getValidUntil());
    }

    public function testUsesCorrectUri()
    {
        $request = new AuthTokenRequest($this->configuration, '1337');
        $this->assertAttributeEquals('https://staging-ws.di.no/ws/json/auth/v-3/login/1337', 'uri', $request);
    }


}
