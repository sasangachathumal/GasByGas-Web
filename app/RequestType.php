<?php

namespace App;

enum RequestType: string
{
    case Costomer = 'COSTOMER';
    case Business = 'BUSINESS';
    case Outlet = 'OUTLET';
}
