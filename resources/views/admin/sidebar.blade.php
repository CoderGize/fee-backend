<div class="min-height-300 bg-dark position-absolute w-100"></div>
<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "
    id="sidenav-main">
    <div class="sidenav-header mb-3">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="" href="{{ url('/') }}">
            <img src="/logo/codergize.svg" width="250px" class="d-block mx-auto p-3" alt="main_logo">
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">

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
                <a class="nav-link rounded-3 {{ '/admin/designers' == request()->path() ? 'main-color' : '' }}"
                    href="{{ url('/admin/designers') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-users text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Designers</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-3 {{ '/admin/collections' == request()->path() ? 'main-color' : '' }}"
                    href="{{ url('/admin/collections') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-shirt text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Collections</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link rounded-3 {{ '/admin/categories' == request()->path() ? 'main-color' : '' }}"
                    href="{{ url('/admin/categories') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-tags text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Categories</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-3 {{ '/admin/subcategories' == request()->path() ? 'main-color' : '' }}"
                    href="{{ url('/admin/subcategories') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-stream text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Subcategories</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-3 {{ '/admin/products' == request()->path() ? 'main-color' : '' }}"
                    href="{{ url('/admin/products') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-box text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">products</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-3 {{ 'admin/show_user' == request()->path() ? 'main-color' : '' }}"
                    href="{{ url('/admin/show_user') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-users text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Users</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link rounded-3 {{ 'admin/show_partner' == request()->path() ? 'main-color' : '' }}"
                    href="{{ url('/admin/show_partner') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-people-fill text-info text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Partners</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link rounded-3 {{ 'admin/show_project' == request()->path() ? 'main-color' : '' }}"
                    href="{{ url('/admin/show_project') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-cast text-success text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Project</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link rounded-3 {{ 'admin/show_blog' == request()->path() ? 'main-color' : '' }}"
                    href="{{ url('/admin/show_blog') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-book text-secondary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Blog</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link rounded-3 {{ 'admin/show_social' == request()->path() ? 'main-color' : '' }}"
                    href="{{ url('/admin/show_social') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-share fs-6 text-sm opacity-10" style="color:rgb(47, 194, 182)"></i>
                    </div>
                    <span class="nav-link-text ms-1">Social Media</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link rounded-3 {{ 'admin/show_subscriber' == request()->path() ? 'main-color' : '' }}"
                    href="{{ url('/admin/show_subscriber') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-envelope fs-6 text-sm opacity-10" style="color:rgb(98, 207, 74)"></i>
                    </div>
                    <span class="nav-link-text ms-1">Subscriber</span>
                </a>
            </li>

        </ul>
    </div>

    <div class="sidenav-footer mx-3 ">
        <div class="card card-plain shadow-none" id="sidenavCard">
            <div class="card-body text-center p-3 w-100 pt-0">
                <div class="docs-info">
                    <p class="text-xs font-weight-bold mt-2 mb-5">
                        <i class="bi bi-arrow-down"></i>
                        Scroll down for more
                        <i class="bi bi-arrow-down"></i>
                    </p>
                    <h6 class="mb-0">Need help?</h6>
                    <p class="text-xs font-weight-bold mb-0">Don't hesitate to contact us</p>
                </div>
            </div>
        </div>
        <a href="" target="_blank" class="btn btn-dark btn-sm w-100 mb-3">
            <i class="bi bi-telephone fs-6 me-1"></i>
            Call
        </a>
    </div>
</aside>
