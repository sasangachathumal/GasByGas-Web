<?php

namespace App;

enum RequestStatusType: string
{
    case Pending = 'PENDING';
    case Paid = 'PAID';
    case Completed = 'COMPLETED';
    case Expired = 'EXPIRED';
}
