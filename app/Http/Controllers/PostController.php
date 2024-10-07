<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
  private $postService;

  public function __construct(PostService $postService)
  {
    $this->postService = $postService;
  }

  public function getAll(Request $request): View
  {
    $page = $request->query('page', 1);
    $search = $request->query('search');
    $response = $this->postService->getAll($page, $search);
    if ($response['success']) {
      return view('admin.post.list', ['data' => $response['data']]);
    } else {
      return view('admin.post.list', ['data' => $response['data']]);
    }
  }
}
