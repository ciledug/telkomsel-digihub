<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'client_id',
        'company',
        'join_date',
        'number_of_apis',
        'legal_entity',
        'business_field',
        'address',
        'company_site',
        'contact_person',
        'cp_position',
        'cp_email',
        'cp_phone',
        'status',
    ];
}
