<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table = 'posts';
    protected $fillable = self::FIELDS;
    public const FIELDS = [
        'slug',
        'title',
        'short_content',
        'image_url',
        'user_id',
        'category_id',
        'reading_time',
        'content'
    ];
}
