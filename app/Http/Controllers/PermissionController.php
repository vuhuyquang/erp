<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class PermissionController extends Controller
{
    private $permissionService;
  
    public function __construct(PermissionService $permissionService)
    {
      $this->permissionService = $permissionService;
    }
  
    public function getAll(Request $request): View
    {
      Gate::authorize('permission.list');
      $page = $request->query('page', 1);
      $search = $request->query('search');
      $response = $this->permissionService->getAll($page, $search);
      if ($response['success']) {
        return view('admin.permission.list', ['data' => $response['data']]);
      } else {
        return view('admin.permission.list', ['data' => $response['data']]);
      }
    }

    public function create(): View
    {
      Gate::authorize('permission.create');
      return view('admin.permission.create');
    }
  
    public function store(CreatePermissionRequest $request): RedirectResponse
    {
      Gate::authorize('permission.create');
      $response = $this->permissionService->store($request);
      if ($response['success']) {
        return redirect()->route('permission');
      } else {
        return redirect()->back();
      }
    }

    public function edit($id): View|RedirectResponse
    {
      Gate::authorize('permission.update');
      $response = $this->permissionService->edit($id);
      if ($response['success']) {
        return view('admin.permission.update', ['permission' => $response['data']]);
      } else {
        return redirect()->route('permission');
      }
    }
  
    public function update(UpdatePermissionRequest $request, $id): RedirectResponse
    {
      Gate::authorize('permission.update');
      $response = $this->permissionService->update($request, $id);
      if ($response['success']) {
        return redirect()->route('permission');
      } else {
        return redirect()->route('permission.edit', ['id' => $id]);
      }
    }
  
    public function destroy($id): RedirectResponse
    {
      Gate::authorize('permission.delete');
      $response = $this->permissionService->delete($id);
      if ($response['success']) {
        return redirect()->route('permission');
      } else {
        return redirect()->route('permission');
      }
    }
}
