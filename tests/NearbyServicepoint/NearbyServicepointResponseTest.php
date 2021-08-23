<?php

namespace Tests\NearbyServicepoint;

use HelthjemSDK\NearbyServicepoint\NearbyServicepointResponse;
use HelthjemSDK\Shared\Exceptions\HelthjemApiResponseException;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

final class NearbyServicepointResponseTest extends TestCase
{
    public function testExceptionIsThrownIfNoFreightProductsAreSet()
    {
        $this->setExpectedException(HelthjemApiResponseException::class);
        new NearbyServicepointResponse([]);
    }

    public function testReturnsFreightProductWithServicePointObjects()
    {
       $response = new NearbyServicepointResponse([
            'freightProducts' => [
                [
                    'transporterId' => 123,
                    'transporterName' => 'test',
                    'freightProductId' => 123,
                    'freightName' => 'test',
                    'freightTitle' => 'test',
                    'freightDescription' => 'test',
                    'servicePoints' => [
                        [
                            'servicePointExternalId' => '123asd',
                            'servicePointName' => 'My servicepoint',
                            'openingHours' => [],
                            'visitingAddress' => 'street',
                            'deliveryAddress' => 'street 2',
                            'routingCode' => '123',
                            'eligibleParcelOutlet' => 'test',
                            'servicePointCoordinates' => []
                        ]
                    ]
                ]
            ]
       ]);

        $this->assertAttributeCount(1, 'freightProducts', $response);
        $this->assertAttributeInstanceOf(Collection::class, 'freightProducts', $response);

        $data = $response->toArray();
        $this->assertCount(1, $data['freightProducts']);
        $this->assertCount(1, $data['freightProducts'][0]['servicePoints']);

        $this->assertTrue(is_array($data['freightProducts']));
        $this->assertEquals('test', $data['freightProducts'][0]['transporterName']);

        $this->assertTrue(is_array($data['freightProducts'][0]['servicePoints']));
        $this->assertEquals('My servicepoint', $data['freightProducts'][0]['servicePoints'][0]['servicePointName']);
    }
}
