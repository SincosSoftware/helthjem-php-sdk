<?php

namespace HelthjemSDK\SingleAddressCheck;

use HelthjemSDK\Shared\Traits\NonNullValueObject;

class SingleAddressCheckResponse
{
    use NonNullValueObject;

    protected $productName;
    protected $routeName;
    protected $companyId;
    protected $routing;
    protected $routingCode;
    protected $routeAddress;
    protected $routeDescription;
    protected $handoverId;
    protected $handoverCity;
    protected $handoverZipCode;
    protected $handoverStreetName;
    protected $handoverStreetNumber;
    protected $handoverDescription;
    protected $routingDescription;
    protected $plannedDeparture;

    public function __construct(array $data)
    {
        $this->fill($data);
    }
}
