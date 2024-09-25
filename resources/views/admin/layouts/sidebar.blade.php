<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0"
            href=" https://demos.creative-tim.com/material-dashboard-pro/pages/dashboards/analytics.html "
            target="_blank">
            <img src="https://demos.creative-tim.com/material-dashboard-pro/assets/img/logo-ct.png"
                class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold text-white">Thương Mại MMO</span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto h-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item mb-2 mt-0">
                <a data-bs-toggle="collapse" href="#ProfileNav" class="nav-link text-white" aria-controls="ProfileNav"
                    role="button" aria-expanded="false">
                    <img src="https://demos.creative-tim.com/material-dashboard-pro/assets/img/team-3.jpg"
                        class="avatar">
                    <span class="nav-link-text ms-2 ps-1">{{ Auth::user()->fullname }}</span>
                </a>
                <div class="collapse" id="ProfileNav" style="">
                    <ul class="nav ">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('get.profile') }}">
                                <span class="sidenav-mini-icon"> H </span>
                                <span class="sidenav-normal  ms-3  ps-1"> Hồ sơ </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white " href="../../pages/pages/account/settings.html">
                                <span class="sidenav-mini-icon"> C </span>
                                <span class="sidenav-normal  ms-3  ps-1"> Cài đặt </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white " href="{{ route('logout') }}">
                                <span class="sidenav-mini-icon"> Đ </span>
                                <span class="sidenav-normal  ms-3  ps-1"> Đăng xuất </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <hr class="horizontal light mt-0">
            <li class="nav-item active">
                <a data-bs-toggle="collapse" href="#dashboardsExamples" class="nav-link text-white active"
                    aria-controls="dashboardsExamples" role="button" aria-expanded="false">
                    <i class="material-icons-round opacity-10">dashboard</i>
                    <span class="nav-link-text ms-2 ps-1">Tổng quan</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4  ms-2 text-uppercase text-xs font-weight-bolder text-white">Trang</h6>
            </li>
            @foreach (Config::get('menu') as $item)
                {{-- @if ($item['bigId'] == 'Ecommerce')
                    <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#ecommerceExamples" class="nav-link text-white "
                            aria-controls="ecommerceExamples" role="button" aria-expanded="false">
                            <i
                                class="material-icons-round {% if page.brand == 'RTL' %}ms-2{% else %} me-2{% endif %}">{{ $item['icon'] }}</i>
                            <span class="nav-link-text ms-2 ps-1">{{ $item['bigLabel'] }}</span>
                        </a>
                        <div class="collapse " id="ecommerceExamples">
                            <ul class="nav ">
                                @foreach ($item['bigItem'] as $subItem)
                                    @can($subItem['can'])
                                        <li class="nav-item ">
                                            <a class="nav-link text-white " data-bs-toggle="collapse" aria-expanded="false"
                                                href="#{{ $subItem['bigId'] }}">
                                                <span class="material-icons-round">
                                                    {{ $subItem['icon'] }}
                                                </span>
                                                <span class="sidenav-normal  ms-2  ps-1"> {{ $subItem['label'] }} <b
                                                        class="caret"></b></span>
                                            </a>
                                            <div class="collapse " id="{{ $subItem['bigId'] }}">
                                                <ul class="nav nav-sm flex-column">
                                                    @foreach ($subItem['item'] as $childItem)
                                                        @can($childItem['can'])
                                                            <li class="nav-item">
                                                                <a class="nav-link text-white "
                                                                    href="{{ route($childItem['route']) }}">
                                                                    <span class="sidenav-mini-icon">
                                                                        {{ Str::ucfirst($childItem['smallLabel'])[0] }} </span>
                                                                    <span class="sidenav-normal  ms-2  ps-1">
                                                                        {{ $childItem['smallLabel'] }} </span>
                                                                </a>
                                                            </li>
                                                        @endcan
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </li>
                                    @endcan
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @endif --}}
                @if ($item['bigId'] == 'Authentication')
                    <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#authExamples" class="nav-link text-white "
                            aria-controls="authExamples" role="button" aria-expanded="false">
                            <i
                                class="material-icons-round {% if page.brand == 'RTL' %}ms-2{% else %} me-2{% endif %}">{{ $item['icon'] }}</i>
                            <span class="nav-link-text ms-2 ps-1">{{ $item['bigLabel'] }}</span>
                        </a>
                        <div class="collapse " id="authExamples">
                            <ul class="nav ">
                                @foreach ($item['bigItem'] as $subItem)
                                    @can($subItem['can'])
                                        <li class="nav-item ">
                                            <a class="nav-link text-white " data-bs-toggle="collapse"
                                                aria-expanded="false" href="#{{ $subItem['bigId'] }}">
                                                <span class="material-icons-round">
                                                    {{ $subItem['icon'] }}
                                                </span>
                                                <span class="sidenav-normal  ms-2  ps-1"> {{ $subItem['label'] }} <b
                                                        class="caret"></b></span>
                                            </a>
                                            <div class="collapse " id="{{ $subItem['bigId'] }}">
                                                <ul class="nav nav-sm flex-column">
                                                    @foreach ($subItem['item'] as $childItem)
                                                        @can($childItem['can'])
                                                            <li class="nav-item">
                                                                <a class="nav-link text-white "
                                                                    href="{{ route($childItem['route']) }}">
                                                                    <span class="sidenav-mini-icon">
                                                                        {{ Str::ucfirst($childItem['smallLabel'])[0] }} </span>
                                                                    <span class="sidenav-normal  ms-2  ps-1">
                                                                        {{ $childItem['smallLabel'] }} </span>
                                                                </a>
                                                            </li>
                                                        @endcan
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </li>
                                    @endcan
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</aside>
