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
    /**
     * @param $value
     * @param $default_host
     * @param $default_port
     * @return array
     * @throws Exception
     * @deprecated
     */
    function envconsul($value, $default_host, $default_port) {
        if (is_envconsul()) {
            try {
                $value = tpenv($value, $default_host);
                $service_array = dns_get_record($value, DNS_SRV);
                if (count($service_array)>0) {
                    $target = $service_array[0]['target'];
                    $port = $service_array[0]['port'];
                } else {
                    return [tpenv($value, $default_host), $default_port];
                }
                $service_array = dns_get_record($target, DNS_A);
                if (count($service_array)>0) {
                    $ip = $service_array[0]['ip'];
                } else {
                    return [tpenv($value, $default_host), $default_port];
                }
            } catch (Exception $e) {
                return [tpenv($value, $default_host), $default_port];
                //throw new Exception('ENVConsul Exception: can not reache host: '.$value); @todo Wie error ?
            }
            return [$ip, $port];
        } else {
            return [tpenv($value, $default_host), $default_port];
        }
    }
}

// Consul Helper

if ( !function_exists('tp_dns_host') ) {
    function tp_dns_host($hostname, $default)
    {
        $service_array = dns_get_record($hostname, DNS_SRV);
        if (is_array($service_array)) {
            if (count($service_array)>0) {
                return $service_array[0]['target'];
            }
        }
        return env($hostname, $default);
    }
}

if ( !function_exists('tp_dns_port') ) {
    function tp_dns_port($hostname, $default)
    {
        $service_array = dns_get_record($hostname, DNS_SRV);
        if (is_array($service_array)) {
            if (count($service_array)>0) {
                return $service_array[0]['port'];
            }
        }
        return env($hostname, $default);
    }
}

if ( !function_exists('tpenvconsul_redis') ) {
    function tpenvconsul_redis($hostname, $hostname_default, $port_default, $datbase=0)
    {
        $redis_host = tp_dns_host($hostname, $hostname_default);
        $redis_port = tp_dns_port($hostname, $port_default);
        return ['host' => $redis_host, 'port' => $redis_port, 'database' => $datbase];
    }
}

if ( !function_exists('tpenvconsul_beanstald') ) {
    function tpenvconsul_beanstald($hostname, $hostname_default, $port_default, $queue='default', $ttr=60)
    {
        $beanstalkd_host = tp_dns_host($hostname, $hostname_default);
        $beanstalkd_port = tp_dns_port($hostname, $port_default);
        return ['driver' => 'beanstalkd', 'host' => $beanstalkd_host, 'port' => $beanstalkd_port, 'queue' => $queue, 'ttr' => $ttr];
    }
}

if (!function_exists('str_get_inner')) {
    /**
     * Parse string between
     *
     * Thank you to http://www.justin-cook.com/wp/2006/03/31/php-parse-a-string-between-two-strings/
     *
     * @param string $string
     * @param string $start
     * @param string $end
     * @return string string
     *
     * @example
     *   $fullstring = 'this is my [tag]dog[/tag]';
     *   $parsed = get_string_between($fullstring, '[tag]', '[/tag]');
     *
     */
    function str_get_inner($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
}