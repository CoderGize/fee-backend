<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.web.css')
</head>

<body class="g-sidenav-show   bg-gray-100">

    @include('admin.web.sidebar')
    <main class="main-content position-relative border-radius-lg ">
        <!-- Navbar -->
        @include('admin.web.navbar')
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>All Social Media</h6>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="d-flex justify-content-center">

                                    <a href="{{ url('/admin/web/update_social/1') }}" class="btn btn-dark">
                                        <i class="bi bi-pen"></i>
                                        Update Social Media Table
                                    </a>

                                </div>
                            </div>
                        </div>

                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center text-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Icon
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Platform
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Link
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                View status
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td>
                                                <i class="bi bi-telephone fs-4">
                                                </i>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    Phone
                                                </p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    {{ $social->phone }}
                                                </p>
                                            </td>
                                            <td>
                                                <span class="badge badge-sm bg-gradient-success">Visible</span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <i class="bi bi-envelope fs-4">
                                                </i>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    Email
                                                </p>
                                            </td>
                                            <td>
                                                @if ($social->email == null)
                                                    <p class="text-xs text-center text-danger font-weight-bold mb-0">
                                                        No Data !
                                                    </p>
                                                @else
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $social->email }}
                                                    </p>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-sm bg-gradient-success">Visible</span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <i class="fa-solid fa-map fs-4"></i>
                                            </td>

                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    Map
                                                </p>
                                            </td>
                                            <td>
                                                @if ($social->map == null)
                                                    <p class="text-xs text-center text-danger font-weight-bold mb-0">
                                                        No Data !
                                                    </p>
                                                @else
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $social->map }}
                                                    </p>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-sm bg-gradient-success">Visible</span>
                                            </td>
                                        </tr>


                                        <tr>
                                            <td>
                                                <i class="fa-solid fa-location-dot fs-4"
                                                    style="color: rgb(194, 6, 6)"></i>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    Location
                                                </p>
                                            </td>
                                            <td>
                                                @if ($social->location == null)
                                                    <p class="text-xs text-center text-danger font-weight-bold mb-0">
                                                        No Data !
                                                    </p>
                                                @else
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $social->location }}
                                                    </p>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-sm bg-gradient-success">Visible</span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <i class="fa-brands fa-instagram fs-4"
                                                    style="background: #d6249f;
                                                            background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%,#d6249f 60%,#285AEB 90%);
                                                            -webkit-background-clip: text;
                                                            -webkit-text-fill-color: transparent;">
                                                </i>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    Instagram
                                                </p>
                                            </td>
                                            <td>
                                                @if ($social->instagram == null)
                                                    <p class="text-xs text-center text-danger font-weight-bold mb-0">
                                                        No Data !
                                                    </p>
                                                @else
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $social->instagram }}
                                                    </p>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($social->instagram_sh == 1)
                                                    <span class="badge badge-sm bg-gradient-success">Visible</span>
                                                @else
                                                    <span class="badge badge-sm bg-gradient-danger">Hidden</span>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <i class="fa-brands fa-facebook-f fs-4" style="color: #3b5998"></i>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    Facebook
                                                </p>
                                            </td>
                                            <td>
                                                @if ($social->facebook == null)
                                                    <p class="text-xs text-center text-danger font-weight-bold mb-0">
                                                        No Data !
                                                    </p>
                                                @else
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $social->facebook }}
                                                    </p>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($social->facebook_sh == 1)
                                                    <span class="badge badge-sm bg-gradient-success">Visible</span>
                                                @else
                                                    <span class="badge badge-sm bg-gradient-danger">Hidden</span>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <i class="fa-brands text-dark fa-tiktok fs-4"></i>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    Tiktok
                                                </p>
                                            </td>
                                            <td>
                                                @if ($social->tiktok == null)
                                                    <p class="text-xs text-center text-danger font-weight-bold mb-0">
                                                        No Data !
                                                    </p>
                                                @else
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $social->tiktok }}
                                                    </p>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($social->tiktok_sh == 1)
                                                    <span class="badge badge-sm bg-gradient-success">Visible</span>
                                                @else
                                                    <span class="badge badge-sm bg-gradient-danger">Hidden</span>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <i class="fa-brands text-danger fa-youtube fs-4"></i>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    Youtube
                                                </p>
                                            </td>
                                            <td>
                                                @if ($social->youtube == null)
                                                    <p class="text-xs text-center text-danger font-weight-bold mb-0">
                                                        No Data !
                                                    </p>
                                                @else
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $social->youtube }}
                                                    </p>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($social->youtube_sh == 1)
                                                    <span class="badge badge-sm bg-gradient-success">Visible</span>
                                                @else
                                                    <span class="badge badge-sm bg-gradient-danger">Hidden</span>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <i class="fa-brands fa-twitter fs-4" style="color: #00acee "></i>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    Twitter
                                                </p>
                                            </td>
                                            <td>
                                                @if ($social->twitter == null)
                                                    <p class="text-xs text-center text-danger font-weight-bold mb-0">
                                                        No Data !
                                                    </p>
                                                @else
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $social->twitter }}
                                                    </p>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($social->twitter_sh == 1)
                                                    <span class="badge badge-sm bg-gradient-success">Visible</span>
                                                @else
                                                    <span class="badge badge-sm bg-gradient-danger">Hidden</span>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <i class="fa-brands fa-dribbble fs-4" style="color: #d6249f"></i>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    Dribble
                                                </p>
                                            </td>
                                            <td>
                                                @if ($social->dribble == null)
                                                    <p class="text-xs text-center text-danger font-weight-bold mb-0">
                                                        No Data !
                                                    </p>
                                                @else
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $social->dribble }}
                                                    </p>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($social->dribble_sh == 1)
                                                    <span class="badge badge-sm bg-gradient-success">Visible</span>
                                                @else
                                                    <span class="badge badge-sm bg-gradient-danger">Hidden</span>
                                                @endif
                                            </td>
                                        </tr>


                                        <tr>
                                            <td>
                                                <i class="fa-brands fa-medium fs-4" style="color: black"></i>
                                            </td>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    Medium
                                                </p>
                                            </td>
                                            <td>
                                                @if ($social->medium == null)
                                                    <p class="text-xs text-center text-danger font-weight-bold mb-0">
                                                        No Data !
                                                    </p>
                                                @else
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $social->medium }}
                                                    </p>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($social->medium_sh == 1)
                                                    <span class="badge badge-sm bg-gradient-success">Visible</span>
                                                @else
                                                    <span class="badge badge-sm bg-gradient-danger">Hidden</span>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <i class="fa-brands fa-behance fs-4"></i>
                                            </td>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    Behance
                                                </p>
                                            </td>
                                            <td>
                                                @if ($social->behance == null)
                                                    <p class="text-xs text-center text-danger font-weight-bold mb-0">
                                                        No Data !
                                                    </p>
                                                @else
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $social->behance }}
                                                    </p>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($social->behance_sh == 1)
                                                    <span class="badge badge-sm bg-gradient-success">Visible</span>
                                                @else
                                                    <span class="badge badge-sm bg-gradient-danger">Hidden</span>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <i class="fa-brands fa-discord fs-4"></i>
                                            </td>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    Discord
                                                </p>
                                            </td>
                                            <td>
                                                @if ($social->discord == null)
                                                    <p class="text-xs text-center text-danger font-weight-bold mb-0">
                                                        No Data !
                                                    </p>
                                                @else
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $social->discord }}
                                                    </p>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($social->discord_sh == 1)
                                                    <span class="badge badge-sm bg-gradient-success">Visible</span>
                                                @else
                                                    <span class="badge badge-sm bg-gradient-danger">Hidden</span>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <i class="fa-brands fa-square-threads fs-4" style="color: black"></i>
                                            </td>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    Threads
                                                </p>
                                            </td>
                                            <td>
                                                @if ($social->threads == null)
                                                    <p class="text-xs text-center text-danger font-weight-bold mb-0">
                                                        No Data !
                                                    </p>
                                                @else
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $social->threads }}
                                                    </p>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($social->threads_sh == 1)
                                                    <span class="badge badge-sm bg-gradient-success">Visible</span>
                                                @else
                                                    <span class="badge badge-sm bg-gradient-danger">Hidden</span>
                                                @endif
                                            </td>
                                        </tr>





                                        <tr>
                                            <td>
                                                <i class="fa-brands fa-snapchat fs-4" style="color: yellow"></i>

                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    Snapchat
                                                </p>
                                            </td>
                                            <td>
                                                @if ($social->snapchat == null)
                                                    <p class="text-xs text-center text-danger font-weight-bold mb-0">
                                                        No Data !
                                                    </p>
                                                @else
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $social->snapchat }}
                                                    </p>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($social->snapchat_sh == 1)
                                                    <span class="badge badge-sm bg-gradient-success">Visible</span>
                                                @else
                                                    <span class="badge badge-sm bg-gradient-danger">Hidden</span>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <i class="fa-brands fa-linkedin-in fs-4" style="color: #0072b1"></i>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    Linkedin
                                                </p>
                                            </td>
                                            <td>
                                                @if ($social->linkedin == null)
                                                    <p class="text-xs text-center text-danger font-weight-bold mb-0">
                                                        No Data !
                                                    </p>
                                                @else
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $social->linkedin }}
                                                    </p>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($social->linkedin_sh == 1)
                                                    <span class="badge badge-sm bg-gradient-success">Visible</span>
                                                @else
                                                    <span class="badge badge-sm bg-gradient-danger">Hidden</span>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <i class="fa-brands fa-whatsapp text-success fs-4"></i>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    Whatsapp
                                                </p>
                                            </td>
                                            <td>
                                                @if ($social->whatsapp == null)
                                                    <p class="text-xs text-center text-danger font-weight-bold mb-0">
                                                        No Data !
                                                    </p>
                                                @else
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $social->whatsapp }}
                                                    </p>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($social->whatsapp_sh == 1)
                                                    <span class="badge badge-sm bg-gradient-success">Visible</span>
                                                @else
                                                    <span class="badge badge-sm bg-gradient-danger">Hidden</span>
                                                @endif
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('admin.web.footer')
        </div>
    </main>

    @include('admin.web.script')

</body>

</html>
