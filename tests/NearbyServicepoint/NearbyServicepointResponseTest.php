<?php

namespace Tests\NearbyServicepoint;

use HelthjemSDK\NearbyServicepoint\NearbyServicepointResponse;
use PHPUnit\Framework\TestCase;

final class NearbyServicepointResponseTest extends TestCase
{
    public function testAlwaysContainsFreightProductArray()
    {
        $response = new NearbyServicepointResponse([]);
        $this->assertArrayHasKey('freightProducts', $response->toArray());
    }
}
