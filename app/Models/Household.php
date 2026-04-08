<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Household extends Model
{
    protected $fillable = ['house_number', 'street', 'purok', 'user_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function residents() {
        return $this->hasMany(Resident::class);
    }
}