<?php

namespace HelthjemSDK\SingleAddressCheck;

use HelthjemSDK\Shared\Exceptions\HelthjemApiResponseException;
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

    /**
     * SingleAddressCheckResponse constructor.
     * @param array $data
     * @throws HelthjemApiResponseException
     */
    public function __construct(array $data)
    {
        $this->fill($data);

        if (!$this->productName) {
            throw new HelthjemApiResponseException('Unable to retrieve helthjem product');
        }
    }
}
