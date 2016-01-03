<?php

namespace TPFoundation\Consul;

class ConsulDNS
{
    protected $hostname;

    protected $target_hostname;
    protected $target_ip;
    protected $target_port;

    public function __construct($hostname)
    {
        $this->hostname = $hostname;
    }

    protected function dns_lookup($hostname)
    {
        $value = dns_get_record($hostname, DNS_SRV);


    }
}