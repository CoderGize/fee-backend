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
                        <div class="card-header pb-0 ">
                            <h6>Download Links Section</h6>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="d-flex justify-content-center">

                                    @include('admin.web.download.update_download')

                                </div>
                            </div>
                        </div>

                        <div class="card-body px-auto pt-0 pb-2">

                            <div class="row mt-4">
                                <div class="col-6 d-block text-center m-auto">
                                    <label for="">
                                        IOS Link
                                    </label>
                                    <p>{{ $download->ios_link }}</p>
                                </div>
                                <div class="col-6 d-block text-center m-auto">
                                    <label for="">
                                        Android Link
                                    </label>
                                    <p>{{ $download->android_link }}</p>
                                </div>
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
