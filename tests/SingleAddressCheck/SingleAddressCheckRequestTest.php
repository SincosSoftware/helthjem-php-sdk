<?php

namespace Tests\SingleAddressCheck;

use Carbon\Carbon;
use HelthjemSDK\Authentication\AuthTokenResponse;
use HelthjemSDK\NearbyServicepoint\NearbyServicepointRequest;
use HelthjemSDK\Shared\Address;
use HelthjemSDK\Shared\Interfaces\Configuration;
use PHPUnit\Framework\TestCase;

final class SingleAddressCheckRequestTest extends TestCase
{
    private $configuration;
    private $address;
    private $authTokenResponse;

    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->createConfiguration();
        $this->createAuthTokenResponse();
        $this->createAddress();
    }

    private function createAddress()
    {
        $this->address = $this->getMock(Address::class);
        $this->address->method('getCustomerName')->willReturn(null);
        $this->address->method('getCountryCode')->willReturn('NO');
        $this->address->method('getCity')->willReturn('Oslo');
        $this->address->method('getZipCode')->willReturn('0468');
        $this->address->method('getStreetAddress')->willReturn('Moldegata 5');
        $this->address->method('getPartyId')->willReturn(null);
        $this->address->method('getDeliveryPointId')->willReturn(null);
        $this->address->method('getCareOf')->willReturn(null);
        $this->address->method('getVolume')->willReturn(null);
        $this->address->method('getWeight')->willReturn(null);
    }

    private function createConfiguration()
    {
        $this->configuration = $this->getMock(Configuration::class);
        $this->configuration->method('getUserName')->willReturn('test');
        $this->configuration->method('getPassword')->willReturn('test');
        $this->configuration->method('isProduction')->willReturn(false);
        $this->configuration->method('getShopId')->willReturn(1);
        $this->configuration->method('getTransportSolutionId')->willReturn(1);
    }

    private function createAuthTokenResponse()
    {
        $this->authTokenResponse = new AuthTokenResponse('test', Carbon::now()->addMinutes(1337));
    }

    public function testCorrectHeadersAreSet()
    {
        $request = new NearbyServicepointRequest($this->authTokenResponse, $this->configuration, $this->address);

        $this->assertArrayHasKey('Content-Type', $request->getHeaders());
        $this->assertArrayHasKey('Authorization', $request->getHeaders());
    }

    public function testCorrectHttpMethodIsSet()
    {
        $request = new NearbyServicepointRequest($this->authTokenResponse, $this->configuration, $this->address);
        $this->assertEquals('POST', $request->getMethod());
    }

    public function testIsUsingCorrectUri()
    {
        $request = new NearbyServicepointRequest($this->authTokenResponse, $this->configuration, $this->address);

        $this->assertEquals('/ws/json/freightcoverage/v-1/servicepoints', $request->getUri()->getPath());
        $this->assertEquals('staging-ws.di.no', $request->getUri()->getHost());
    }
}
