<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientApiRequest extends Model
{
    protected $fillable = [
        'client_id', 'transaction_id', 'product_id', 'consent_ref', 'created_at_timestamp'
    ];
}
