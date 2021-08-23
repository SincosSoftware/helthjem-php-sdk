<?php

namespace HelthjemSDK\NearbyServicepoint;

use HelthjemSDK\Shared\Traits\NonNullValueObject;
use Illuminate\Contracts\Support\Arrayable;

class FreightProduct implements Arrayable
{
    use NonNullValueObject;

    protected $transporterId;
    protected $transporterName;
    protected $freightProductId;
    protected $freightName;
    protected $freightTitle;
    protected $freightDescription;
    protected $servicePoints;

    public function __construct(array $data)
    {
        $servicePoints = [];

        if (isset($data['servicePoints'])) {
            foreach ($data['servicePoints'] as $servicePoint) {
                $servicePoints[] = new ServicePoint($servicePoint);
            }
        }

        $data['servicePoints'] = collect($servicePoints);

        $this->fill($data);
    }
}
