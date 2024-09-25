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
                        <h6 class="text-white text-capitalize ps-3">Bảng người dùng</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-4">
                            <div class="dataTable-top">
                                <div class="dataTable-search">
                                    <form id="searchForm" action="{{ route('user') }}">
                                        <div class="input-group input-group-outline">
                                            <label class="form-label">Tìm kiếm</label>
                                            <input type="text" id="searchInput" name="search" class="form-control"
                                                onfocus="focused(this)" onfocusout="defocused(this)" autocomplete="off">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Người
                                        dùng</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tài
                                        khoản</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Trạng thái</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Ngày bắt đầu</th>
                                    <th style="width: 40px;" class="text-secondary opacity-7"></th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($data && !empty($data->items()))
                                    @foreach ($data->items() as $user)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="{{ asset('storage/images/' . $user->avatar) }}"
                                                            class="avatar avatar-sm me-3 border-radius-lg"`>
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $user->fullname }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ $user->email }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $user->username }}</p>
                                                <p class="text-xs text-secondary mb-0">
                                                    @foreach ($user->roles as $key => $role)
                                                        {{ $role->description }}
                                                        @if ($key < count($user->roles) - 1)
                                                            ,
                                                        @endif
                                                    @endforeach
                                                </p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                @if ($user->status == 1)
                                                    <span class="badge badge-sm bg-gradient-success">Đang hoạt động</span>
                                                @elseif ($user->status == 0)
                                                    <span class="badge badge-sm bg-gradient-secondary">Đang tạm khóa</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    @isset($user->created_at)
                                                        {{ date('d-m-Y', strtotime($user->created_at)) }}
                                                    @else
                                                        <i>N/A</i>
                                                    @endisset
                                                </span>
                                            </td>
                                            <td>
                                                <div class="ms-auto text-end d-flex justify-content-around">
                                                    @can('user.update')
                                                    <a onclick="location.href='{{ route('user.edit', ['id' => $user->id]) }}'" class="btn btn-link text-dark px-3 mb-0" href="javascript:;">
                                                        <i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>
                                                        Sửa
                                                    </a>
                                                    @endcan
                                                    @can('user.delete')
                                                    <form action="{{ route('user.destroy', ['id' => $user->id]) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button onclick="return confirm('Xóa bản ghi này?');" class="btn btn-link text-danger text-gradient px-3 mb-0"
                                                            href="javascript:;">
                                                            <i class="far fa-trash-alt me-2" aria-hidden="true"></i>
                                                            Xóa
                                                        </button>
                                                    </form>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        @if ($data && $data->lastPage() > 1)
                            <div
                                class="d-flex justify-content-center justify-content-sm-between flex-wrap align-items-center">
                                <div class="ms-3">
                                    <p class="text-sm"> Hiển thị {{ ($data->currentPage() - 1) * $data->perPage() + 1 }}
                                        đến {{ $data->currentPage() * $data->perPage() }} trong {{ $data->total() }} mục
                                    </p>
                                </div>
                                <ul class="pagination pagination-success pagination-md me-3" modelvalue="1">
                                    <li onclick="changePage('{{ $data->url($data->currentPage() - 1) }}')"
                                        class="page-item prev-page disabled"><a class="page-link"
                                            aria-label="Previous"><span aria-hidden="true"><i class="fa fa-angle-left"
                                                    aria-hidden="true"></i></span></a></li>
                                    @for ($i = 1; $i <= $data->lastPage(); $i++)
                                        <li onclick="changePage('{{ $data->url($i) }}')"
                                            class="page-item disabled {{ $data->currentPage() == $i ? 'active' : '' }}"><a
                                                class="page-link {{ $data->currentPage() == $i ? 'text-white' : '' }}">{{ $i }}</a>
                                        </li>
                                    @endfor
                                    <li onclick="changePage('{{ $data->url($data->currentPage() + 1) }}')"
                                        class="page-item next-page disabled"><a class="page-link" aria-label="Next"><span
                                                aria-hidden="true"><i class="fa fa-angle-right"
                                                    aria-hidden="true"></i></span></a></li>
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/js/admin/user.js') }}"></script>
@endsection
