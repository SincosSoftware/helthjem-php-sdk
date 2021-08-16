<?php

namespace HelthjemSDK\NearbyServicepoint\ValueObjects;

use HelthjemSDK\Shared\Traits\NonNullValueObject;

/**
 * For property details, see https://jira-di.atlassian.net/wiki/spaces/DIPUB/pages/1413251073/Parcel+Nearby+Servicepoint+API
 * Class Address
 * @package HelthjemSDK\NearbyServicepoint\ValueObjects
 */
class Address
{
    use NonNullValueObject;

    protected $countryCode;
    protected $postalName;
    protected $zipCode;
    protected $streetAddress;
    protected $coAddress;

}
