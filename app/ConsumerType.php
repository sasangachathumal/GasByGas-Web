<?php

namespace App;

enum ConsumerType: string
{
    case Customer = 'CUSTOMER';
    case Business = 'BUSINESS';
    case Outlet = 'OUTLET';
}
