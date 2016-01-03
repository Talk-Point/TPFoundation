<?php

namespace TPFoundation\Consul;

use Exception;

/**
 * ConsulBaseClass
 *
 * Basis Class to get information from consul
 *
 * @package TPConsul
 */
class ConsulBaseClass
{
    /**
     * ConsulBaseClass constructor.
     */
    public function __construct()
    {

    }

    /**
     * DNS SRV Lookup
     * @param $hostname
     * @return array
     * @throws Exception
     */
    protected function dns_lookup_srv($hostname)
    {
        $service_array = $this->dns_lookup($hostname, $type=DNS_SRV);

        $service_array = $service_array[0];
        if (! array_has_keys(['type', 'weight', 'port', 'target'], $service_array)) {
            throw new Exception('Wrong Keys'); // @todo Update
        }

        return $service_array;
    }

    /**
     * DNS A Lookup
     * @param $hostname
     * @return array
     * @throws Exception
     */
    protected function dns_lookup_a($hostname)
    {
        $service_array = $this->dns_lookup($hostname);

        $service_array = $service_array[0];
        if (! array_has_keys(['host', 'type', 'ip'], $service_array)) {
            throw new Exception('Wrong Keys'); // @todo Update
        }

        return $service_array;
    }

    /**
     * DNS Lookup
     * @param $hostname
     * @return array
     * @throws Exception
     */
    protected function dns_lookup($hostname, $type=DNS_A)
    {
        $service_array = dns_get_record($hostname, $type);
        if (count($service_array) < 1) {
            throw new Exception('No Services Found'); // @todo Update
        }
        return $service_array;
    }

}