<?php

namespace App;

enum StatusType: string
{
    case Pending = 'PENDING';
    case Approved = 'APPROVED';
    case Rejected = 'REJECTED';
    case Completed = 'COMPLETED';
}
