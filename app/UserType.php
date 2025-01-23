<?php

namespace App;

enum UserType: string
{
    case Admin = 'ADMIN';
    case Outlet_Manager = 'OUTLET_MANAGER';
    case Consumer = 'CONSUMER';
}
