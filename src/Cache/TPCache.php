<?php

namespace TPFoundation\Cache;

use Illuminate\Support\Facades\Facade;

class TPCache extends Facade
{
    protected static function getFacadeAccessor() { return 'tpcache'; }
}