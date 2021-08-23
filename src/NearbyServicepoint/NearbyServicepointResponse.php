<?php

namespace HelthjemSDK\NearbyServicepoint;

use HelthjemSDK\Shared\Exceptions\HelthjemApiResponseException;
use HelthjemSDK\Shared\Traits\NonNullValueObject;
use Illuminate\Contracts\Support\Arrayable;

class NearbyServicepointResponse implements Arrayable
{
    use NonNullValueObject;

    protected $freightProducts = [];

    /**
     * NearbyServicepointResponse constructor.
     * @param array $data
     * @throws HelthjemApiResponseException
     */
    public function __construct(array $data)
    {
        $freightProducts = [];

        if (!isset($data['freightProducts'])) {
            throw new HelthjemApiResponseException('No freightProducts found');
        }

        foreach ($data['freightProducts'] as $freightProduct) {
            $freightProducts[] = new FreightProduct($freightProduct);
        }

        $data['freightProducts'] = collect($freightProducts);

        $this->fill($data);

        if ($this->freightProducts->isEmpty()) {
            throw new HelthjemApiResponseException('No freightProducts found');
        }

    }
}
