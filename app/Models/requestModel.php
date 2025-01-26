<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class requestModel extends Model
{
    protected $table = 'requests';

    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'schedule_id',
        'gas_id',
        'consumer_id',
        'status',
        'type',
        'token',
        'quantity',
        'expired_at'
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
