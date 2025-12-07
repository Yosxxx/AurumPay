<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recipient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'recipient_account_number',
        'recipient_name'
    ];
}
