<?php

namespace App\Repositories\Implements;

use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Models\Post;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(Post::class);
        $this->fields = Post::FIELDS;
    }
}
