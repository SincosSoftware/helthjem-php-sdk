<?php

namespace Tests\SingleAddressCheck\ValueObjects;

use HelthjemSDK\SingleAddressCheck\ValueObjects\Address;
use PHPUnit\Framework\TestCase;

final class AddressTest extends TestCase
{
    public function testCanCreateFromArray()
    {

        $data = [
            'customerName' => 'Petter Testman',
            'countryCode' => 'NO',
            'postalName' => 'Rørvik',
            'zipCode' => '7900',
            'address' => 'Strandgata 1',
            'partyId' => 11,
            'deliveryPointId' => 11,
            'co' => '',
            'volume' => 15,
            'weight' => 105
        ];
        $address = Address::fromArray($data);
        $this->assertEquals($address->toArray(), $data);
    }

    public function testNullValuesAreOmittedWhenReturned()
    {
        $data = [
            'customerName' => 'Petter Testman',
            'countryCode' => 'NO',
            'postalName' => 'Rørvik',
            'zipCode' => '7900',
            'address' => 'Strandgata 1',
            'partyId' => null,
            'deliveryPointId' => 11,
            'co' => '',
            'volume' => 15,
            'weight' => 105
        ];

        $address = Address::fromArray($data);
        $this->assertArrayNotHasKey('partyId', $address->toArray());
    }

    public function testUnknownPropertiesAreOmitted()
    {
        $data = [
            'customerName' => 'Petter Testman',
            'countryCode' => 'NO',
            'postalName' => 'Rørvik',
            'zipCode' => '7900',
            'address' => 'Strandgata 1',
            'partyId' => 1,
            'deliveryPointId' => 11,
            'co' => '',
            'volume' => 15,
            'weight' => 105,
            'unknown' => 'property'
        ];

        $address = Address::fromArray($data);
        $this->assertArrayNotHasKey('unknown', $address->toArray());
    }

    public function testEmptyArrayIsReturnedIfNothingIsProvided()
    {
        $data = [];
        $address = Address::fromArray($data);
        $this->assertCount(0, $address->toArray());
    }
}
