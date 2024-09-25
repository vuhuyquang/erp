@extends('admin.layouts.main')

@section('title')
    Hồ sơ cá nhân
@endsection

@section('breadcrumb')
    Hồ sơ cá nhân
@endsection

@section('main')
    <div class="container-fluid px-2 px-md-4">
        <div class="page-header min-height-300 border-radius-xl mt-4"
            style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1920&amp;q=80');">
            <span class="mask  bg-gradient-primary  opacity-0"></span>
        </div>
    </div>

    <div class="row mb-5 mt-4">
        <div class="col-lg-3">
            <div class="card position-sticky top-1">
                <ul class="nav flex-column bg-white border-radius-lg p-3">
                    <li class="nav-item">
                        <a class="nav-link text-dark d-flex" data-scroll="" href="#profile">
                            <i class="material-icons text-lg me-2">person</i>
                            <span class="text-sm">Hồ sơ cá nhân</span>
                        </a>
                    </li>
                    <li class="nav-item pt-2">
                        <a class="nav-link text-dark d-flex" data-scroll="" href="#basic-info">
                            <i class="material-icons text-lg me-2">receipt_long</i>
                            <span class="text-sm">Thông tin cơ bản</span>
                        </a>
                    </li>
                    <li class="nav-item pt-2">
                        <a class="nav-link text-dark d-flex" data-scroll="" href="#password">
                            <i class="material-icons text-lg me-2">lock</i>
                            <span class="text-sm">Đổi mật khẩu</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-lg-9 mt-lg-0 mt-4">

            <div class="card card-body" id="profile">
                <div class="row justify-content-center align-items-center">
                    <div class="col-sm-auto col-4">
                        <div class="avatar avatar-xl position-relative">
                            <img src="https://demos.creative-tim.com/material-dashboard-pro/assets/img/team-3.jpg"
                                alt="User" class="w-100 rounded-circle shadow-sm">
                        </div>
                    </div>
                    <div class="col-sm-auto col-8 my-auto">
                        <div class="h-100">
                            <h5 class="mb-1 font-weight-bolder">
                                {{ Auth::user()->fullname ?? '' }}
                            </h5>
                            <p class="mb-0 font-weight-normal text-sm">
                                {{ Auth::user()->roles->first()->description }}
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-auto ms-sm-auto mt-sm-0 mt-3 d-flex">
                        <label class="form-check-label mb-0">
                            <small id="profileVisibility">
                                Trạng thái hoạt động
                            </small>
                        </label>
                        <div class="form-check form-switch ms-2 my-auto">
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault23" checked=""
                                onchange="visible()">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4" id="basic-info">
                <div class="card-header">
                    <h5>Thông tin cơ bản</h5>
                </div>
                <div class="card-body pt-0">
                    <form action="" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="input-group input-group-static">
                                    <label>Tài khoản</label>
                                    <input type="text" name="username" value="{{ Auth::user()->username }}"
                                        class="form-control" placeholder="Tài khoản" onfocus="focused(this)"
                                        onfocusout="defocused(this)" disabled spellcheck="false">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group input-group-static">
                                    <label>Họ tên</label>
                                    <input type="text" name="fullname" value="{{ Auth::user()->fullname }}"
                                        class="form-control" placeholder="Họ tên" onfocus="focused(this)"
                                        onfocusout="defocused(this)" autocomplete="off" spellcheck="false">
                                    @error('fullname')
                                        <p class="help-block text-sm">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-6">
                                <div class="input-group input-group-static">
                                    <label>Email</label>
                                    <input type="email" name="email" value="{{ Auth::user()->email }}"
                                        class="form-control" placeholder="example@email.com" onfocus="focused(this)"
                                        onfocusout="defocused(this)" autocomplete="off" spellcheck="false">
                                    @error('email')
                                        <p class="help-block text-sm">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group input-group-static">
                                    <label>Trạng thái</label>
                                    <input type="email" value="{{ Auth::user()->status == 1 ? 'Đang hoạt động' : 'Đang tạm khóa' }}"
                                        class="form-control" placeholder="example@email.com" onfocus="focused(this)"
                                        onfocusout="defocused(this)" disabled>
                                    @error('fullname')
                                        <p class="help-block text-sm">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button style="submit" class="btn bg-gradient-dark btn-sm float-end mt-6 mb-0">Cập nhật</button>
                    </form>
                </div>
            </div>

            <div class="card mt-4" id="password">
                <div class="card-header">
                    <h5>Đổi mật khẩu</h5>
                </div>
                <div class="card-body pt-0">
                    <form action="{{ route('post.change.password') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="input-group input-group-static">
                                    <label>Mật khẩu hiện tại</label>
                                    <input type="password" name="oldPassword" class="form-control"
                                        onfocus="focused(this)" onfocusout="defocused(this)" autocomplete="off" spellcheck="false">
                                    @error('oldPassword')
                                        <p class="help-block text-sm">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="input-group input-group-static">
                                    <label>Mật khẩu mới</label>
                                    <input type="password" name="password" class="form-control" onfocus="focused(this)"
                                        onfocusout="defocused(this)" autocomplete="off" spellcheck="false">
                                    @error('password')
                                        <p class="help-block text-sm">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="input-group input-group-static">
                                    <label>Xác nhận mật khẩu</label>
                                    <input type="password" name="reNewPassword" class="form-control"
                                        onfocus="focused(this)" onfocusout="defocused(this)" autocomplete="off" spellcheck="false">
                                    @error('reNewPassword')
                                        <p class="help-block text-sm">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <h5 class="mt-5">Yêu cầu mật khẩu</h5>
                        <p class="text-muted mb-2">
                            Vui lòng làm theo hướng dẫn này để có một mật khẩu mạnh:
                        </p>
                        <ul class="text-muted ps-4 mb-0 float-start">
                            <li>
                                <span class="text-sm">Một chữ thường</span>
                            </li>
                            <li>
                                <span class="text-sm">Một chữ hoa</span>
                            </li>
                            <li>
                                <span class="text-sm">Một số (khuyến nghị 2)</span>
                            </li>
                            <li>
                                <span class="text-sm">Một ký tự đặc biệt</span>
                            </li>
                            <li>
                                <span class="text-sm">Tối thiểu 7 ký tự</span>
                            </li>
                            <li>
                                <span class="text-sm">Thay đổi nó thường xuyên</span>
                            </li>
                        </ul>
                        <button class="btn bg-gradient-dark btn-sm float-end mt-6 mb-0">Cập nhật</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
