<?php /** Log */

namespace TPFoundation\Log;

use Illuminate\Support\Facades\Facade;

class TPLog extends Facade
{
    protected static function getFacadeAccessor() { return 'tplog'; }
}