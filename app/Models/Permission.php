<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $table = 'permissions';
    protected $fillable = self::FIELDS;
    public const FIELDS = [
        'scope',
        'description',
        'is_system',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_permissions');
    }
}
