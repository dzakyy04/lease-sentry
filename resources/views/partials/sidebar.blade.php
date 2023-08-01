<div class="nk-sidebar nk-sidebar-fixed is-light " data-content="sidebarMenu">
    <div class="nk-sidebar-element nk-sidebar-head">
        <div class="nk-sidebar-brand">
            <a href="" class="logo-link nk-sidebar-logo">
                <img class="logo-light logo-img" src="{{ asset('assets/images/logo-kpknl.png') }}"
                    srcset="./images/logo2x.png 2x" alt="logo">
                <img class="logo-dark logo-img" src="{{ asset('assets/images/logo-kpknl.png') }}"
                    srcset="./images/logo-dark2x.png 2x" alt="logo-dark">
                <img class="logo-small logo-img logo-img-small" src="{{ asset('assets/images/logo.png') }}"
                    srcset="./images/logo-small2x.png 2x" alt="logo-small">
            </a>
        </div>
        <div class="nk-menu-trigger me-n2">
            <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em
                    class="icon ni ni-arrow-left"></em></a>
            <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex"
                data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
        </div>
    </div>
    <div class="nk-sidebar-element">
        <div class="nk-sidebar-content">
            <div class="nk-sidebar-menu" data-simplebar>
                <ul class="nk-menu">
                    <li class="nk-menu-item">
                        <a href="{{ route('dashboard.index') }}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-dashboard"></em></span>
                            <span class="nk-menu-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-file-text"></em></span>
                            <span class="nk-menu-text">Dokumen</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{ route('document2020.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">2020</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('document2021.index')}}" class="nk-menu-link">
                                    <span class="nk-menu-text">2021</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('document2022.index')}}" class="nk-menu-link">
                                    <span class="nk-menu-text">2022</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="html/project-card.html" class="nk-menu-link">
                                    <span class="nk-menu-text">2023</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nk-menu-item">
                        <a href="{{ route('conceptor.index') }}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                            <span class="nk-menu-text">Konseptor</span>
                        </a>
                    </li>
                    <li class="nk-menu-item">
                        <a href="{{ route('holiday.index') }}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-calender-date"></em></span>
                            <span class="nk-menu-text">Hari Libur</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
