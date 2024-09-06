<div class="min-height-300 bg-dark position-absolute w-100"></div>
<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "
    id="sidenav-main">
    <div class="sidenav-header mb-3">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="" href="{{ url('/') }}">
            <img src="/fee-logo/2.png" width="150px" class="d-block mx-auto p-3" alt="main_logo">
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">

            <div class="btn-group text-center d-flex mx-auto mt-1" role="group" aria-label="Basic example">
                <a type="button" href="{{ url('/admin/web/show_landing') }}"
                    class="btn {{ request()->is('admin/web*') ? 'btn-primary' : 'btn-outline-primary' }}">
                    Web Content
                </a>
                <a type="button" href="{{ url('/admin') }}"
                    class="btn {{ !request()->is('admin/web*') ? 'btn-primary' : 'btn-outline-primary' }}">
                    POS
                </a>
            </div>

            <li class="nav-item">
                <a class="nav-link rounded-3 {{ 'admin' == request()->path() ? 'main-color' : '' }}"
                    href="{{ url('/admin') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link rounded-3 {{ request()->is('admin/designers*') ? 'main-color' : ' ' }}"
                    href="{{ url('/admin/designers') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-users text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Designers</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-3 {{ request()->is('admin/collections*') ? 'main-color' : ' ' }}"
                    href="{{ url('/admin/collections') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-shirt text-info text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Collections</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link rounded-3 {{ request()->is('admin/categories*') ? 'main-color' : ' ' }}"
                    href="{{ url('/admin/categories') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-tags text-black text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Categories</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-3 {{ request()->is('admin/subcategories*') ? 'main-color' : ' ' }}"
                    href="{{ url('/admin/subcategories') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-stream text-secondary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Subcategories</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-3 {{ request()->is('admin/products*') ? 'main-color' : ' ' }}"
                    href="{{ url('/admin/products') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-box text-sm opacity-10" style="color: rgb(12, 52, 230)"></i>
                    </div>
                    <span class="nav-link-text ms-1">products</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-3 {{ request()->is('admin/users*') ? 'main-color' : ' ' }}"
                    href="{{ url('/admin/users') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-users text-sm opacity-10" style="color: rgb(238, 0, 255)"></i>
                    </div>
                    <span class="nav-link-text ms-1">Users</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-3 {{ request()->is('admin/orders*') ? 'main-color' : ' ' }}"
                    href="{{ url('/admin/orders') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-shopping-cart text-sm opacity-10" style="color: rgb(42, 198, 107)"></i>
                    </div>
                    <span class="nav-link-text ms-1">Orders</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link rounded-3 {{ request()->is('admin/payments*') ? 'main-color' : ' ' }}"
                    href="{{ url('/admin/payments') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-money-bill text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Payments</span>
                </a>
            </li>

        </ul>
    </div>

    <div class="sidenav-footer mx-3 ">
        <div class="card card-plain shadow-none" id="sidenavCard">
            <div class="card-body text-center px-3 w-100 pt-0">
                <div class="docs-info">
                    <p class="text-xs font-weight-bold mt-2 mb-3">
                        <i class="bi bi-arrow-down"></i>
                        Scroll down for more
                        <i class="bi bi-arrow-down"></i>
                    </p>
                    <h6 class="mb-0">Need help?</h6>
                    <p class="text-xs font-weight-bold mb-0">Don't hesitate to contact us</p>
                </div>
            </div>
        </div>
        <a href="" target="_blank" class="btn btn-dark btn-sm w-100 mb-1">
            <i class="bi bi-telephone fs-6 me-1"></i>
            Call
        </a>

        <a href="{{ route('logout') }}" target="_blank" class="btn btn-danger btn-sm w-100 mb-3"
            onclick="event.preventDefault(); if(confirm('Are you sure you want to logout?')) document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-left fs-6 me-1"></i>
            Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>

</aside>
