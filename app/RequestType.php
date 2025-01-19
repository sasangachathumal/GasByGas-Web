<?php

namespace App;

enum RequestType: string
{
    case Consumer = 'CONSUMER';
    case Business = 'BUSINESS';
    case Outlet = 'OUTLET';
}
