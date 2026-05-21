<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'title', 'content', 'category', 'event_date', 'created_by'
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}