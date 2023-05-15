<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientApiResponse extends Model
{
    protected $fillable = [
        'request_id', 'status_code', 'status_description'
    ];
}
