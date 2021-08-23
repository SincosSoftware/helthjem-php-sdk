<?php

namespace HelthjemSDK\NearbyServicepoint;

use HelthjemSDK\Shared\Traits\NonNullValueObject;
use Illuminate\Contracts\Support\Arrayable;

class ServicePoint implements Arrayable
{
    use NonNullValueObject;

    protected $servicePointExternalId;
    protected $servicePointName;
    protected $openingHours = [];
    protected $visitingAddress;
    protected $deliveryAddress;
    protected $routingCode;
    protected $eligibleParcelOutlet;
    protected $servicePointCoordinates = [];

    public function __construct(array $data)
    {
        $this->fill($data);
    }
}
