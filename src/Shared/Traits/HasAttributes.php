<?php

namespace HelthjemSDK\Shared\Traits;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

trait HasAttributes
{
    protected $properties;

    public function __toString()
    {
        return json_encode($this->toArray());
    }

    public function fill(array $data)
    {
        $data = array_intersect_key($data, array_flip($this->getProperties()));

        foreach ($data as $property => $value) {
            $this->setAttribute($property, $value);
        }

        return $this;
    }

    public static function fromArray(array $data)
    {
        $object = new static;
        $object->fill($data);

        return $object;
    }

    public function toResponse()
    {
        return $this->toArray();
    }

    public function toArray()
    {
        return iterator_to_array($this->propertiesToIterator());
    }

    protected function propertiesToIterator()
    {
        foreach ($this->getProperties() as $property) {
            if ($this->$property instanceof Arrayable) {
                yield $property => $this->$property->toArray();
            } else {
                yield $property => $this->$property;
            }
        }
    }

    protected function setAttribute($property, $value)
    {
        if ($this->hasSetMutator($property)) {
            $this->setWithMutator($property, $value);
        } elseif ($this->hasProperty($property)) {
            $this->$property = $value;
        }
    }

    protected function hasSetMutator($property)
    {
        return method_exists($this, $this->getMutatorName($property));
    }

    protected function setWithMutator($property, $value)
    {
        $this->{$this->getMutatorName($property)}($value);
    }

    protected function getMutatorName($property)
    {
        return 'set' . Str::studly($property) . 'Attribute';
    }

    public function __get($name)
    {
        $name = Str::snake($name);
        if ($this->hasProperty($name)) {
            return $this->$name;
        }
    }

    public function __isset($name)
    {
        return isset($this->{$name}) || isset($this->{Str::snake($name)});
    }

    protected function hasProperty($name)
    {
        return in_array($name, $this->getProperties());
    }

    protected function getProperties()
    {
        if (null === $this->properties) {
            $properties = get_object_vars($this);
            unset($properties['properties']);
            $this->properties = array_keys($properties);
        }

        return $this->properties;
    }
}
