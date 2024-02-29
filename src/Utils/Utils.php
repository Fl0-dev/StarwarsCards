<?php

class Utils
{
    /**
     * Get property object without error
     *
     * @param string $prop   Property to get
     * @param mixed $object Object
     *
     * @return mixed|null
     */
    public static function getProp($prop, $object)
    {
        if (is_object($object) && property_exists($object, $prop)) {
            return $object->{$prop};
        }

        return null;
    }

    /**
     * Get value in an array without error
     *
     * @param string $key   Key of the value to get
     * @param array  $array Array
     *
     * @return mixed|null
     */
    public static function getArrayValue($key, $array)
    {
        if (is_int($key) || is_string($key)) {
            if (is_array($array) && array_key_exists($key, $array)) {
                return $array[$key];
            }
        }

        return null;
    }

    /**
     * Get values for a given key and array of filters
     *
     * @param string $key
     * @param array $filters
     *
     * @return string|array|null
     */
    public static function getArrayValueOfFilters($key, $filters)
    {
        return self::getArrayValue('value', self::getArrayValue($key, $filters));
    }
}
