<?php

namespace TPFoundation\Consul;

/**
 * Consul Service
 * @package TPConsul
 */
class Service extends ConsulBaseClass
{
    /**
     * @var string Hoastname
     */
    protected $service_name;

    /**
     * @var string Target Hostname
     */
    protected $target_hostname;
    /**
     * @var
     */
    protected $target_ip;
    /**
     * @var
     */
    protected $target_port;

    /**
     * Get A Service from Consul
     * @param string $service_name
     * @return Service
     */
    public static function getFirst($service_name)
    {
        $s = new Service($service_name);
        $s->querry();
        return $s;
    }

    /**
     * Service constructor.
     * @param $service_name
     */
    public function __construct($service_name)
    {
        parent::__construct();
        $this->service_name = $service_name;
    }

    /**
     * Query the data for the Service from Consul
     * @throws \Exception
     */
    public function querry()
    {
        $array = $this->dns_lookup_srv($this->service_name);
        $this->target_hostname = $array['target'];
        $this->target_port = $array['port'];

        $array = $this->dns_lookup_a($this->target_hostname);
        $this->target_ip = $array['ip'];
    }

    /**
     * Return Hostname
     * @return string
     */
    public function getServicename()
    {
        return $this->service_name;
    }

    /**
     * Return Target Hostname
     * @return string
     */
    public function getTargetHostname()
    {
        return $this->target_hostname;
    }

    /**
     * Return Target IP
     * @return string
     */
    public function getTargetIp()
    {
        return $this->target_ip;
    }

    /**
     * Return Target Port
     * @return int
     */
    public function getTargetPort()
    {
        return $this->target_port;
    }

}