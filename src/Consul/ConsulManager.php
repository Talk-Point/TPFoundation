<?php

namespace TPFoundation\Consul;

/**
 * Consul Manager
 * @package TPConsul
 */
class ConsulManager
{
    protected $services = [];

    /**
     * @var null
     */
    protected static $_instance = null;

    /**
     * Singleton Getter
     * @return ConsulManager
     */
    public static function getInstance()
    {
        if (null === self::$_instance)
        {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    /**
     * Clone Fkt.
     */
    protected function __clone() {}

    /**
     * ConsulManager constructor.
     */
    protected function __construct() {}

    /**
     * Return A Consul Service
     * @param $string
     * @return Service
     */
    public function getService($string)
    {
        if (array_key_exists($string, $this->services)) {
            return $this->services[$string];
        } else {
            $service = Service::getFirst($string);
            $this->services[$string] = $service;
            return $service;
        }
    }
}