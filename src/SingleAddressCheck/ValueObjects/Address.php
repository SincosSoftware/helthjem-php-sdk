<?php

namespace HelthjemSDK\SingleAddressCheck\ValueObjects;

use HelthjemSDK\Shared\Traits\NonNullValueObject;

/**
 * For property details, see https://jira-di.atlassian.net/wiki/spaces/DIPUB/pages/90639259/Parcel+Single+Address+Check+API
 * Class Address
 * @package HelthjemSDK\SingleAddressCheck\ValueObjects
 */
class Address
{
    use NonNullValueObject;

    protected $customerName;
    protected $countryCode;
    protected $postalName;
    protected $zipCode;
    protected $address;
    protected $partyId;
    protected $deliveryPointId;
    protected $co;
    protected $volume;
    protected $weight;


}
