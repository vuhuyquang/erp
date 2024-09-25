@extends('admin.layouts.auth-main')

@section('title')
    Đặt lại mật khẩu
@endsection

@section('main')
    <div class="container my-auto">
        <div class="row">
            <form action="{{ route('recover.password') }}" method="POST">
                @csrf
                <div class="col-lg-4 col-md-7 mx-auto">
                    <div class="card z-index-0 my-auto fadeIn3 fadeInBottom">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-success shadow-success border-radius-lg py-3 text-center">
                                <h4 class="font-weight-bolder text-white mb-0 mt-1">Đặt lại mật khẩu</h4>
                                {{-- <p class="text-white mb-1">Bạn sẽ nhận được mã gửi tới mail trong tối đa 60s</p> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="input-group input-group-static mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" name="email"
                                    placeholder="email@example.com" autocomplete="off">
                            </div>
                            <div>
                                @error('email')
                                    <small class="help-block text-sm">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn bg-gradient-success btn-lg w-100 my-4 mb-2">Gửi</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
