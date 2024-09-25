@extends('admin.layouts.mail')

@section('title')
    {{ $data['password'] }} là mã khôi phục tài khoản Facebook của bạn
@endsection

@section('heading')
    Đặt lại mật khẩu
@endsection

@section('content')
    <p>
    <p>Xin chào {{ $data['fullname'] }},</p>
    <p>Chúng tôi đã nhận được yêu cầu đặt lại mật khẩu MMO của bạn.</p>
    <p>Nhập mã đặt lại mật khẩu sau đây:</p>
    <p>
        <i>
            <strong>{{ $data['password'] }}</strong>
        </i>
    </p>
    <p>Cảm ơn bạn!</p>
    </p>
@endsection
