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