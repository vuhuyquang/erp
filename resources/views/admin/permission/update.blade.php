@extends('admin.layouts.main')

@section('title')
    Quyền
@endsection

@section('breadcrumb')
    Quyền
@endsection

@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Cập nhật quyền</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <form action="{{ route('permission.update', ['id' => $permission->id]) }}" method="POST">
                        @csrf
                        <div class="card-body row">
                            <div class="form-group col-6">
                                <div class="input-group input-group-dynamic is-filled">
                                    <label for="scope" class="form-label">Scope</label>
                                    <input class="multisteps-form__input form-control" type="text" id="scope"
                                        name="scope" value="{{ $permission->scope }}" spellcheck="false" autocomplete="off"
                                        onfocus="focused(this)" onfocusout="defocused(this)">
                                </div>
                                @error('scope')
                                    <small class="help-block">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-6">
                                <div class="input-group input-group-dynamic is-filled">
                                    <label for="description" class="form-label">Mô tả</label>
                                    <input class="multisteps-form__input form-control" type="text" id="description"
                                        name="description" value="{{ $permission->description }}" spellcheck="false" autocomplete="off"
                                        onfocus="focused(this)" onfocusout="defocused(this)">
                                </div>
                                @error('description')
                                    <small class="help-block">{{ $message }}</small>
                                @enderror
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