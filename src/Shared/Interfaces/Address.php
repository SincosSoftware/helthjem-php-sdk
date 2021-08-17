<?php

namespace HelthjemSDK\Shared\Interfaces;

interface Address
{
    public function getCountryCode();
    public function getCity();
    public function getZipCode();
    public function getStreetAddress();
    public function getCareOf();
    public function getCustomerName();
    public function getPartyId();
    public function getDeliveryPointId();
    public function getVolume();
    public function getWeight();
}
