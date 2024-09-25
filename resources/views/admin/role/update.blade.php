@extends('admin.layouts.main')

@section('title')
    Vai trò
@endsection

@section('breadcrumb')
    Vai trò
@endsection

@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Cập nhật vai trò</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <form action="{{ route('role.update', ['id' => $data['role']->id ]) }}" method="POST">
                        @csrf
                        <div class="card-body row">
                            <div class="form-group col-6">
                                <div class="input-group input-group-dynamic is-filled">
                                    <label for="name" class="form-label">Vai trò</label>
                                    <input class="multisteps-form__input form-control" type="text" id="name"
                                        name="name" value="{{ $data['role']->name }}" spellcheck="false" autocomplete="off"
                                        onfocus="focused(this)" onfocusout="defocused(this)">
                                </div>
                                @error('name')
                                    <small class="help-block">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-6">
                                <div class="input-group input-group-dynamic is-filled">
                                    <label for="description" class="form-label">Mô tả</label>
                                    <input class="multisteps-form__input form-control" type="text" id="description"
                                        name="description" value="{{ $data['role']->description }}" spellcheck="false" autocomplete="off"
                                        onfocus="focused(this)" onfocusout="defocused(this)">
                                </div>
                                @error('description')
                                    <small class="help-block">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="card-body row">
                            <div class="form-group col-6">
                                <div class="input-group input-group-dynamic is-filled">
                                    <label for="permissions" class="form-label">Quyền</label>
                                    <div class="form-group mt-3">
                                        @foreach ($data['permissions'] as $key => $permission)
                                            <div class="custom-control custom-checkbox">
                                                <input {{ in_array($permission->id, $data['rolePermission']) ? 'checked' : '' }} class="custom-control-input" type="checkbox" name="permissions[]"
                                                    id={{ $key + 1 }} value={{ $permission->id }}>
                                                <label for={{ $key + 1 }}
                                                    class="custom-control-label">{{ $permission->description }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @error('permissions')
                                <small class="help-block">{{ $message }}</small>
                            @enderror
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