<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    protected $fillable = [
        'household_id', 'first_name', 'last_name',
        'birthdate', 'gender', 'relationship', 'contact_number'
    ];

    public function household() {
        return $this->belongsTo(Household::class);
    }
}