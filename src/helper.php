<?php

if (!function_exists("tpenv")) {

    /**
     * Setzt eine ENV Variable oder feuert eine Exception wenn der Default Wert nicht gesetzt ist
     * @param $var
     * @param null $default
     * @param Exception $exception
     */
    function tpenv($var, $default=null)
    {
        $value = getenv($var);
        if (is_null($default)) {
            if($value == false) {
                throw new Exception('tpenv: $default is null and $var is not set:'.$var);
            }
            return $value;
        } else {
            if($value == false) {
                return $default;
            } else {
                return $value;
            }
        }
    }
}

if (!function_exists("array_key_not_exits_exception")) {
    /**
     * Testen ob der Key exestiert ansonsten eine Exception werfen
     * @param string $key
     * @param array $array
     * @param Exception|string $exception
     * @throws Exception
     */
    function array_key_not_exits_exception($key, $array, $exception)
    {
        if (!array_key_exists($key, $array)) {
            if (is_object($exception)) {
                throw new $exception;
            } else {
                throw new Exception($exception);
            }
        }
    }
}

if (!function_exists("underscore2Camelcase")) {
    /**
     * Underscore to CamcelCase
     * @param $str
     * @return string
     */
    function underscore2Camelcase($str)
    {
        // Split string in words.
        $words = explode('_', strtolower($str));

        $return = '';
        foreach ($words as $word) {
            $return .= ucfirst(trim($word));
        }

        return $return;
    }
}
