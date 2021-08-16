<?php

namespace HelthjemSDK\Shared\Traits;

trait NonNullValueObject
{
    use HasAttributes {
        HasAttributes::toArray as baseToArray;
    }

    public function toArray()
    {
        return array_filter($this->baseToArray(), function($value){
            return !is_null($value);
        });
    }
}
