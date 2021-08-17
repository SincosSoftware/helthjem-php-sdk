<?php

namespace HelthjemSDK\Shared;

use HelthjemSDK\Shared\Traits\NonNullValueObject;
use HelthjemSDK\Shared\Interfaces\Address as AddressInterface;

class Address implements AddressInterface
{
    use NonNullValueObject;

    protected $countryCode;
    protected $city;
    protected $zipCode;
    protected $streetAddress;
    protected $coStreetAddress;
    protected $careOf;
    protected $customerName;
    protected $partId;
    protected $deliveryPointId;
    protected $volume;
    protected $weight;


    public function getCountryCode()
    {
        return $this->countryCode;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getZipCode()
    {
        return $this->zipCode;
    }

    public function getStreetAddress()
    {
        return $this->streetAddress;
    }

    public function getCoStreetAddress()
    {
        return $this->coStreetAddress;
    }

    public function getCareOf()
    {
        return $this->careOf;
    }

    public function getCustomerName()
    {
        return $this->customerName;
    }

    public function getPartyId()
    {
        return $this->partId;
    }

    public function getDeliveryPointId()
    {
        return $this->deliveryPointId;
    }

    public function getVolume()
    {
        return $this->volume;
    }

    public function getWeight()
    {
        return $this->weight;
    }
}
