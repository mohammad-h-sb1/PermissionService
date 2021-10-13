<?php

namespace Saberyp\Cms;

use Illuminate\Support\Facades\Facade;

class PermissionFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Permission';
    }
}
