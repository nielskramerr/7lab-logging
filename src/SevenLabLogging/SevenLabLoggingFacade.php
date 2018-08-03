<?php

namespace SevenLabLogging;

use Illuminate\Support\Facades\Facade;

class SevenLabLoggingFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return '7lab-logging';
    }
}
