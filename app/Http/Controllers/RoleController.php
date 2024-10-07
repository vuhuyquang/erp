<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Brian2694\Toastr\Facades\Toastr;

class RoleController extends Controller
{
    private $roleService;
  
    public function __construct(RoleService $roleService)
    {
      $this->roleService = $roleService;
    }
  
    public function getAll(Request $request): View
    {
      Gate::authorize('role.list');
      $page = $request->query('page', 1);
      $search = $request->query('search');
      $response = $this->roleService->getAll($page, $search);
      if ($response['success']) {
        return view('admin.role.list', ['breadcrumb' => 'Vai trò', 'data' => $response['data']]);
      } else {
        return view('admin.role.list', ['breadcrumb' => 'Vai trò', 'data' => $response['data']]);
      }
    }
  
    public function create(): View
    {
      Gate::authorize('role.create');
      $response = $this->roleService->create();
      return view('admin.role.create', ['breadcrumb' => 'Vai trò', 'permissions' => $response['data']]);
    }

    public function store(CreateRoleRequest $request): RedirectResponse
    {
      Gate::authorize('role.create');
      $response = $this->roleService->store($request);
      if ($response['success']) {
        Toastr::success($response['message'], 'Thành công');
        return redirect()->route('role');
      } else {
        Toastr::error($response['message'], 'Thất bại');
        return redirect()->back();
      }
    }
  
    public function edit($id): View|RedirectResponse
    {
      Gate::authorize('role.update');
      $response = $this->roleService->edit($id);
      if ($response['success']) {
        return view('admin.role.update', ['data' => $response['data'], 'breadcrumb' => 'Vai trò']);
      } else {
        return redirect()->route('role');
      }
    }

    public function update(UpdateRoleRequest $request, $id): RedirectResponse
    {
      Gate::authorize('role.update');
      $response = $this->roleService->update($request, $id);
      if ($response['success']) {
        Toastr::success($response['message'], 'Thành công');
        return redirect()->route('role');
      } else {
        Toastr::error($response['message'], 'Thất bại');
        return redirect()->route('role.edit', ['id' => $id]);
      }
    }
  
    public function destroy($id): RedirectResponse
    {
      Gate::authorize('role.delete');
      $response = $this->roleService->delete($id);
      if ($response['success']) {
        Toastr::success($response['message'], 'Thành công');
        return redirect()->route('role');
      } else {
        Toastr::error($response['message'], 'Thất bại');
        return redirect()->route('role');
      }
    }
}
