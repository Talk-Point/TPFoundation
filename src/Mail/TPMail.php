<?php

namespace TPFoundation\Mail;

use Illuminate\Support\Facades\Facade;

class TPMail extends Facade
{
    protected static function getFacadeAccessor() { return 'tpmail'; }
}