<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id', 'user_name', 'role',
        'action', 'module', 'description', 'ip_address'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper method to log activity anywhere
    public static function log($action, $module, $description = null)
    {
        if (auth()->check()) {
            self::create([
                'user_id'     => auth()->id(),
                'user_name'   => auth()->user()->name,
                'role'        => auth()->user()->role,
                'action'      => $action,
                'module'      => $module,
                'description' => $description,
                'ip_address'  => request()->ip(),
            ]);
        }
    }
}