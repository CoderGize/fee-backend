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
                            <h6>About Section</h6>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="d-flex justify-content-center">

                                    @include('admin.web.about.update_about')

                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">

                            <div class="col-12 d-block m-auto text-center">
                                <label for="">
                                    Image
                                    <span class="text-danger fw-light fs-xs">
                                        *1200x800*
                                    </span>
                                </label>
                                <img src="{{$about->img}}" class="w-25 d-block m-auto" alt="">
                            </div>

                        </div>

                        <div class="row mb-3">

                            <div class="col-12 col-sm-6 d-block m-auto text-center">
                                <label for="">
                                    <img src="/img/en.png" width="15px" alt="">
                                    About Text
                                </label>
                                <p>{{$about->about_en}}</p>
                            </div>

                            <div class="col-12 col-sm-6 d-block m-auto text-center">
                                <label for="">
                                    <img src="/img/ar.png" width="15px" alt="">
                                    About Text
                                </label>
                                <p>{{$about->about_ar}}</p>
                            </div>

                        </div>

                        <div class="row mb-3">

                            <div class="col-12 col-sm-6 d-block m-auto text-center">
                                <label for="">
                                    <img src="/img/en.png" width="15px" alt="">
                                    Our Vision Text
                                </label>
                                <p>{{$about->vision_en}}</p>
                            </div>

                            <div class="col-12 col-sm-6 d-block m-auto text-center">
                                <label for="">
                                    <img src="/img/ar.png" width="15px" alt="">
                                    Our Vision Text
                                </label>
                                <p>{{$about->vision_ar}}</p>
                            </div>

                        </div>

                        <div class="row mb-3">

                            <div class="col-12 col-sm-6 d-block m-auto text-center">
                                <label for="">
                                    <img src="/img/en.png" width="15px" alt="">
                                    Our Mission Text
                                </label>
                                <p>{{$about->mission_en}}</p>
                            </div>

                            <div class="col-12 col-sm-6 d-block m-auto text-center">
                                <label for="">
                                    <img src="/img/ar.png" width="15px" alt="">
                                    Our Mission Text
                                </label>
                                <p>{{$about->mission_ar}}</p>
                            </div>

                        </div>

                        <div class="row mb-3">

                            <div class="col-12 col-sm-6 d-block m-auto text-center">
                                <label for="">
                                    <img src="/img/en.png" width="15px" alt="">
                                    Why Us Title
                                </label>
                                <p>{{$about->whyus_title_en}}</p>
                            </div>

                            <div class="col-12 col-sm-6 d-block m-auto text-center">
                                <label for="">
                                    <img src="/img/ar.png" width="15px" alt="">
                                    Why Us Title
                                </label>
                                <p>{{$about->whyus_title_ar}}</p>
                            </div>

                        </div>

                        <div class="row mb-3">

                            <div class="col-12 col-sm-6 d-block m-auto text-center">
                                <label for="">
                                    <img src="/img/en.png" width="15px" alt="">
                                    Why Us Text
                                </label>
                                <p>{{$about->whyus_text_en}}</p>
                            </div>

                            <div class="col-12 col-sm-6 d-block m-auto text-center">
                                <label for="">
                                    <img src="/img/ar.png" width="15px" alt="">
                                    Why Us Text
                                </label>
                                <p>{{$about->whyus_text_ar}}</p>
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
