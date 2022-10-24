<?php

namespace Zampou\CinetPay\Facades;

use Illuminate\Support\Facades\Facade;
use Zampou\CinetPay\Providers\CinetPayProvider;

class CinetPay extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return CinetPayProvider::SINGLETON;
    }
}
