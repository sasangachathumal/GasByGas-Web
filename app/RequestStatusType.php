<?php

namespace App;

enum RequestStatusType: string
{
    case Pending = 'PENDING';
    case Paid = 'PAID';
    case Picked = 'PICKED';
    case Expired = 'EXPIRED';
}
