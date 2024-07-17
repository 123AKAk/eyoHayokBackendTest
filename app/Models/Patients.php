<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patients extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 'last_name', 'card_no_id', 'email', 'phone_no', 'marital_status', 'date_of_birth', 'age', 'nationality', 'country', 'city_town', 'address', 'next_of_kin_name', 'next_of_kin_phone_no', 'relationship', 'next_of_kin_email_address', 'next_of_kin_address'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
