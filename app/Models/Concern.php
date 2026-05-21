<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Concern extends Model
{
    protected $fillable = [
        'user_id', 'category', 'title', 'description', 'location', 'status', 'admin_response'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}