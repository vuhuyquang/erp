<?php

namespace App\Services;

use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PostService extends BaseService
{
  private $postRepository;

  public function __construct(PostRepositoryInterface $postRepository)
  {
    $this->postRepository = $postRepository;
  }

  public function getAll($page, $search): array
  {
    try {
      $response = $this->postRepository->select(['id', 'slug', 'title', 'short_content', 'image_url', 'user_id', 'post_category_id', 'reading_time', 'content'])
    } catch (\Throwable $th) {
      //throw $th;
    }
  }
}
