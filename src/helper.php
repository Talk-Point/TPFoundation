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

if (!function_exists("array_has_keys")) {
    function array_has_keys($keys, $array) {
        foreach ($keys as $key) {
            if (!array_key_exists($key, $array)) {
                return false;
            }
        }
        return true;
    }
}

/**
 * Consul Helper
 */
if ( !function_exists('is_envconsul')) {
    function is_envconsul()
    {
        return tpenv('APP_CONSUL', false);
    }
}

if (!function_exists('envconsul')) {
    function envconsul($value, $default_host, $default_port) {
        if (is_envconsul()) {
            try {
                $service_array = dns_get_record($value, DNS_SRV);
                $port = $service_array[0]['port'];
                $target = $service_array[0]['target'];
                $service_array = dns_get_record($target, DNS_A);
                $ip = $service_array[0]['ip'];
            } catch (Exception $e) {
                throw new Exception('ENVConsul Exception: can not reache host: '.$value);
            }
            return [$ip, $port];
        } else {
            return [tpenv($value, $default_host), $default_port];
        }
    }
}
