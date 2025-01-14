<?php

namespace App;

enum RequestType: string
{
    case Consumer = 'CONSUMERS';
    case Business = 'BUSINESS';
    case Outlet = 'OUTLET';
}
