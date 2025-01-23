<?php

namespace App;

enum RequestType: string
{
    case Customer = 'CUSTOMER';
    case Business = 'BUSINESS';
}
