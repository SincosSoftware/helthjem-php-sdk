<?php

namespace Tests\NearbyServicepoint\ValueObjects;

use HelthjemSDK\NearbyServicepoint\ValueObjects\Address;
use PHPUnit\Framework\TestCase;

final class AddressTest extends TestCase
{
    public function testCanCreateFromArray()
    {
        $data = [
            'countryCode' => 'NO',
            'postalName' => 'Rørvik',
            'zipCode' => '7900',
            'streetAddress' => 'Strandgata 1',
        ];
        $address = Address::fromArray($data);
        $this->assertEquals($address->toArray(), $data);
    }

    public function testUnknownPropertiesAreOmitted()
    {
        $data = [
            'countryCode' => 'NO',
            'postalName' => 'Rørvik',
            'zipCode' => '7900',
            'streetAddress' => 'Strandgata 1',
            'unknown' => 'Property'
        ];

        $address = Address::fromArray($data);
        $this->assertArrayNotHasKey('unknown', $address->toArray());
    }

    public function testNullValuesAreOmittedWhenReturned()
    {
        $data = [
            'countryCode' => 'NO',
            'postalName' => 'Rørvik',
            'zipCode' => '7900',
            'streetAddress' => null,
        ];

        $address = Address::fromArray($data);
        $this->assertArrayNotHasKey('streetAddress', $address->toArray());
    }

    public function testEmptyArrayIsReturnedIfNothingIsProvided()
    {
        $data = [];
        $address = Address::fromArray($data);
        $this->assertCount(0, $address->toArray());
    }
}
