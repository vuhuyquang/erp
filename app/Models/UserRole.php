<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;
    protected $table = 'users_roles';
    protected $fillable = self::FIELDS;
    public const FIELDS = [
        'user_id',
        'role_id',
    ];
}
