<div class="min-height-300 bg-dark position-absolute w-100"></div>
<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "
    id="sidenav-main">
    <div class="sidenav-header mb-3">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="" href="{{ url('/admin') }}">
            <img src="/fee-logo/2.png" width="150px" class="d-block mx-auto p-3" alt="main_logo">
        </a>
    </div>

    <hr class="horizontal dark mt-0">



    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">

        <ul class="navbar-nav">

            <div class="btn-group text-center d-flex mx-auto" role="group" aria-label="Basic example">
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
                <a class="nav-link rounded-3 {{ 'admin/web/show_landing' == request()->path() ? 'main-color' : '' }}"
                    href="{{ url('/admin/web/show_landing') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-1-circle fs-6 text-sm opacity-10" style="color:rgb(47, 194, 182)"></i>
                    </div>
                    <span class="nav-link-text ms-1">Landing</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link rounded-3 {{ 'admin/web/show_carousel' == request()->path() ? 'main-color' : '' }}"
                    href="{{ url('/admin/web/show_carousel') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-file-image fs-6 text-sm opacity-10" style="color:rgb(84, 47, 194)"></i>
                    </div>
                    <span class="nav-link-text ms-1">Item Carousel</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link rounded-3 {{ 'admin/web/show_showroom' == request()->path() ? 'main-color' : '' }}"
                    href="{{ url('/admin/web/show_showroom') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-person-standing-dress fs-6 text-sm opacity-10 text-danger"
                            style="color: rgb(194, 64, 47))"></i>
                    </div>
                    <span class="nav-link-text ms-1">Showroom</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link rounded-3 {{ 'admin/web/show_about' == request()->path() ? 'main-color' : '' }}"
                    href="{{ url('/admin/web/show_about') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-file-earmark-person-fill text-sm opacity-10"
                            style="color: rgb(181, 13, 184)"></i>
                    </div>
                    <span class="nav-link-text ms-1">About FEE</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link rounded-3 {{ 'admin/web/show_instagrid' == request()->path() ? 'main-color' : '' }}"
                    href="{{ url('/admin/web/show_instagrid') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-stickies fs-6 text-sm opacity-10 " style="color: rgb(0, 0, 0)"></i>
                    </div>
                    <span class="nav-link-text ms-1">Instagram Section</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link rounded-3 {{ 'admin/web/show_designer_story' == request()->path() ? 'main-color' : '' }}"
                    href="{{ url('/admin/web/show_designer_story') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-brush text-info text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Designer Story</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link rounded-3 {{ 'admin/web/show_testimonial' == request()->path() ? 'main-color' : '' }}"
                    href="{{ url('/admin/web/show_testimonial') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-star-fill text-sm opacity-10" style="color: rgb(181, 184, 0)"></i>
                    </div>
                    <span class="nav-link-text ms-1">Customer Testimonials</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link rounded-3 {{ 'admin/web/show_blog' == request()->path() ? 'main-color' : '' }}"
                    href="{{ url('/admin/web/show_blog') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-card-text text-sm opacity-10" style="color: rgb(175, 0, 184)"></i>
                    </div>
                    <span class="nav-link-text ms-1">Blog</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link rounded-3 {{ 'admin/web/show_download' == request()->path() ? 'main-color' : '' }}"
                    href="{{ url('/admin/web/show_download') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-cloud-download text-sm opacity-10" style="color: rgb(0, 30, 255)"></i>
                    </div>
                    <span class="nav-link-text ms-1">App Download Links</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link rounded-3 {{ 'admin/web/show_become_designer' == request()->path() ? 'main-color' : '' }}"
                    href="{{ url('/admin/web/show_become_designer') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-award fs-6 text-sm opacity-10 text-danger"
                            style="color: rgb(194, 64, 47))"></i>
                    </div>
                    <span class="nav-link-text ms-1">Become a Designer</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link rounded-3 {{ 'admin/web/show_contact' == request()->path() ? 'main-color' : '' }}"
                    href="{{ url('/admin/web/show_contact') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-telephone fs-6 text-sm opacity-10" style="color:rgb(84, 47, 194)"></i>
                    </div>
                    <span class="nav-link-text ms-1">Contact Page</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link rounded-3 {{ 'admin/web/show_newsletter' == request()->path() ? 'main-color' : '' }}"
                    href="{{ url('/admin/web/show_newsletter') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-envelope fs-6 text-sm opacity-10 " style="color: rgb(0, 0, 0)"></i>
                    </div>
                    <span class="nav-link-text ms-1">Subscribers</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link rounded-3 {{ 'admin/web/show_designletter' == request()->path() ? 'main-color' : '' }}"
                    href="{{ url('/admin/web/show_designletter') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-paint-bucket fs-6 text-sm opacity-10 " style="color: rgb(225, 137, 137)"></i>
                    </div>
                    <span class="nav-link-text ms-1">Designers Advert</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link rounded-3 {{ 'admin/web/show_social' == request()->path() ? 'main-color' : '' }}"
                    href="{{ url('/admin/web/show_social') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-share fs-6 text-sm opacity-10" style="color:rgb(47, 194, 182)"></i>
                    </div>
                    <span class="nav-link-text ms-1">Social Media</span>
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
