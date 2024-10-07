<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RecoverPasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Brian2694\Toastr\Facades\Toastr;

class UserController extends Controller
{
  private $userService;

  public function __construct(UserService $userService)
  {
    $this->userService = $userService;
  }

  public function getAll(Request $request): View
  {
    Gate::authorize('user.list');
    $page = $request->query('page', 1);
    $search = $request->query('search');
    $response = $this->userService->getAll($page, $search);
    if ($response['success']) {
      return view('admin.user.list', ['data' => $response['data']]);
    } else {
      return view('admin.user.list', ['data' => $response['data']]);
    }
  }

  public function create(): View
  {
    Gate::authorize('user.create');
    $response = $this->userService->create();
    return view('admin.user.create', ['roles' => $response['data']]);
  }

  public function store(CreateUserRequest $request): RedirectResponse
  {
    Gate::authorize('user.create');
    $response = $this->userService->store($request);
    if ($response['success']) {
      Toastr::success($response['message'], 'Thành công');
      return redirect()->route('user');
    } else {
      Toastr::error($response['message'], 'Thất bại');
      return redirect()->back();
    }
  }

  public function edit($id): View|RedirectResponse
  {
    Gate::authorize('user.update');
    $response = $this->userService->edit($id);
    if ($response['success']) {
      return view('admin.user.update', ['data' => $response['data']]);
    } else {
      return redirect()->route('user');
    }
  }

  public function update(UpdateUserRequest $request, $id): RedirectResponse
  {
    Gate::authorize('user.update');
    $response = $this->userService->update($request, $id);
    if ($response['success']) {
      Toastr::success($response['message'], 'Thành công');
      return redirect()->route('user');
    } else {
      Toastr::error($response['message'], 'Thất bại');
      return redirect()->route('user.edit', ['id' => $id]);
    }
  }

  public function destroy($id): RedirectResponse
  {
    Gate::authorize('user.delete');
    $response = $this->userService->delete($id);
    if ($response['success']) {
      Toastr::success($response['message'], 'Thành công');
      return redirect()->route('user');
    } else {
      Toastr::error($response['message'], 'Thất bại');
      return redirect()->route('user');
    }
  }

  public function getLogin(): View
  {
    return view('admin.auth.login');
  }

  public function postLogin(LoginRequest $request): RedirectResponse
  {
    $response = $this->userService->login($request);
    if ($response['success']) {
      return redirect()->route('get.profile');
    } else {
      return redirect()->back();
    }
  }

  public function logout(): RedirectResponse
  {
    $this->userService->logout();
    return redirect()->route('getLogin');
  }

  public function getProfile(): View
  {
    return view('admin.auth.profile', ['breadcrumb' => 'Hồ sơ cá nhân']);
  }

  public function postProfile(UpdateProfileRequest $request): RedirectResponse
  {
    $response = $this->userService->postProfile($request);
    if ($response['success']) {
      Toastr::success($response['message'], 'Thành công');
      return redirect()->route('get.profile');
    } else {
      Toastr::error($response['message'], 'Thất bại');
      return redirect()->back();
    }
  }

  public function changePassword(ChangePasswordRequest $request): RedirectResponse
  {
    $response = $this->userService->changePassword($request);
    if ($response['success']) {
      Toastr::success($response['message'], 'Thành công');
      return redirect()->route('get.profile');
    } else {
      Toastr::error($response['message'], 'Thất bại');
      return redirect()->back();
    }
  }

  public function getResetPassword(): View
  {
    return view('admin.auth.reset-password');
  }

  public function recover(RecoverPasswordRequest $request): RedirectResponse
  {
    $response = $this->userService->resetPassword($request);
    if ($response['success']) {
      Toastr::success($response['message'], 'Thành công');
      return redirect()->route('getLogin');
    } else {
      return redirect()->back();
    }
  }
}
