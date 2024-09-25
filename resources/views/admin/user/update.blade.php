@extends('admin.layouts.main')

@section('title')
    Người dùng
@endsection

@section('breadcrumb')
    Người dùng
@endsection

@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Cập nhật người dùng</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <form action="{{ route('user.update', ['id' => $data['user']->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card-body row">
                            <div class="form-group col-6">
                                <div class="input-group input-group-dynamic is-filled">
                                    <label for="username" class="form-label">Tài khoản</label>
                                    <input class="multisteps-form__input form-control" type="text" id="username"
                                        name="username" value="{{ $data['user']->username }}" spellcheck="false"
                                        autocomplete="off" onfocus="focused(this)" onfocusout="defocused(this)" readonly>
                                </div>
                                @error('username')
                                    <small class="help-block">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-6">
                                <div class="input-group input-group-dynamic is-filled">
                                    <label for="fullname" class="form-label">Họ tên</label>
                                    <input class="multisteps-form__input form-control" type="text" id="fullname"
                                        name="fullname" value="{{ $data['user']->fullname }}" spellcheck="false"
                                        autocomplete="off" onfocus="focused(this)" onfocusout="defocused(this)">
                                </div>
                                @error('fullname')
                                    <small class="help-block">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="card-body row">
                            <div class="form-group col-4">
                                <div class="input-group input-group-dynamic is-filled">
                                    <label for="email" class="form-label">Email</label>
                                    <input class="multisteps-form__input form-control" type="text" id="email"
                                        name="email" value="{{ $data['user']->email }}" spellcheck="false"
                                        autocomplete="off" onfocus="focused(this)" onfocusout="defocused(this)">
                                </div>
                                @error('email')
                                    <small class="help-block">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-4">
                                <div class="input-group input-group-dynamic is-filled">
                                    <label for="password" class="form-label">Mật khẩu</label>
                                    <input class="multisteps-form__input form-control" type="text" id="password"
                                        name="password" value="{{ old('password') }}" spellcheck="false" autocomplete="off"
                                        onfocus="focused(this)" onfocusout="defocused(this)">
                                </div>
                                @error('password')
                                    <small class="help-block">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-4">
                                <div class="input-group input-group-dynamic is-filled">
                                    <label for="status" class="form-label">Trạng thái</label>
                                    <select class="form-control" style="height: 40.2px;" id="status" name="status"
                                        onfocus="focused(this)" onfocusout="defocused(this)" onclick="focused(this)">
                                        <option {{ $data['user']->status == 1 ? 'selected' : '' }} value="1">Đang hoạt
                                            động</option>
                                        <option {{ $data['user']->status == 0 ? 'selected' : '' }} value="0">Đang tạm
                                            khóa</option>
                                    </select>
                                </div>
                                @error('status')
                                    <small class="help-block">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="card-body row">
                            <div class="form-group col-6">
                                <div class="input-group input-group-dynamic is-filled">
                                    <label for="roles" class="form-label">Vai trò</label>
                                    <div class="form-group mt-3">
                                        @foreach ($data['roles'] as $key => $role)
                                            <div class="custom-control custom-checkbox">
                                                <input {{ in_array($role->id, $data['userRole']) ? 'checked' : '' }}
                                                    class="custom-control-input" type="checkbox" name="roles[]"
                                                    id={{ $key + 1 }} value={{ $role->id }}>
                                                <label for={{ $key + 1 }}
                                                    class="custom-control-label">{{ $role->description }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @error('roles')
                                    <small class="help-block">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="multisteps-form__content col-6">
                                <div class="row mt-3">
                                    <label for="avatar" class="form-label">Ảnh đại diện</label>
                                    <div action="/file-upload" class="form-control border dropzone dz-clickable"
                                        id="avatar">
                                        <div class="dz-default dz-message">
                                            <button class="dz-button" type="button">Chọn file để tải lên
                                                <input type="file" name="avatar" accept=".jpg, .png, .jpeg">
                                            </button>
                                        </div>
                                    </div>
                                    @error('avatar')
                                        <small class="help-block">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
