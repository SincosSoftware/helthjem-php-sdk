<?php

namespace Tests\SingleAddressCheck;

use Carbon\Carbon;
use HelthjemSDK\Authentication\AuthTokenResponse;
use HelthjemSDK\NearbyServicepoint\NearbyServicepointRequest;
use HelthjemSDK\NearbyServicepoint\ValueObjects\Address;
use HelthjemSDK\Shared\Interfaces\Configuration;
use PHPUnit\Framework\TestCase;

final class SingleAddressCheckRequestTest extends TestCase
{
    private $configuration;
    private $authTokenResponse;

    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->createConfiguration();
        $this->createAuthTokenResponse();
    }


    private function createConfiguration()
    {
        $this->configuration = $this->getMock(Configuration::class);
        $this->configuration->method('getUserName')->willReturn('test');
        $this->configuration->method('getPassword')->willReturn('test');
        $this->configuration->method('isProduction')->willReturn(false);
        $this->configuration->method('getShopId')->willReturn(1);
        $this->configuration->method('getTransportSolutionId')->willReturn(2);
        $this->configuration->method('getBaseUri')->willReturn('https://test.test/');
    }

    private function createAuthTokenResponse()
    {
        $this->authTokenResponse = new AuthTokenResponse('test', Carbon::now()->addMinutes(1337));
    }

    public function testCorrectHeadersAreSet()
    {
        $address = $this->getMock(Address::class);
        $address->method('toArray')->willReturn([]);
        $request = new NearbyServicepointRequest($this->authTokenResponse, $this->configuration, $address);

        $this->assertArrayHasKey('Content-Type', $request->getHeaders());
        $this->assertArrayHasKey('Authorization', $request->getHeaders());
    }

    public function testCorrectHttpMethodIsSet()
    {
        $address = $this->getMock(Address::class);
        $address->method('toArray')->willReturn([]);
        $request = new NearbyServicepointRequest($this->authTokenResponse, $this->configuration, $address);

        $this->assertEquals('POST', $request->getMethod());
    }

    public function testIsUsingCorrectUri()
    {
        $address = $this->getMock(Address::class);
        $address->method('toArray')->willReturn([]);
        $request = new NearbyServicepointRequest($this->authTokenResponse, $this->configuration, $address);

        $this->assertEquals('/freightcoverage/v-1/servicepoints', $request->getUri()->getPath());
        $this->assertEquals('test.test', $request->getUri()->getHost());
    }

    public function testRequestDataIsSet()
    {
        $address = $this->getMock(Address::class);
        $address->method('toArray')->willReturn([
            'someAddressPropertyName' => 'someAddressPropertyValue'
        ]);

        $request = new NearbyServicepointRequest($this->authTokenResponse, $this->configuration, $address);
        $requestData = json_decode((string) $request->getBody(), true);
        $addressData = $address->toArray();

        foreach ($addressData as $key => $data) {
            $this->assertArrayHasKey($key, $requestData);
            $this->assertEquals($data, $requestData[$key]);
        }

        $this->assertArrayHasKey('shopId', $requestData);
        $this->assertEquals(1, $requestData['shopId']);
        $this->assertArrayhasKey('transportSolutionId', $requestData);
        $this->assertEquals(2, $requestData['transportSolutionId']);
    }
}
