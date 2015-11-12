<?php /** Dynamische Propertys */

namespace TPFoundation\DataStructure;


abstract class DynamicProperty
{
    public function __get($field)
    {
        if(property_exists($this, $field)) {
            return $this->{$field};
        }
    }

    public function __set($field, $value)
    {
        $this->{$field} = $value;
    }
}