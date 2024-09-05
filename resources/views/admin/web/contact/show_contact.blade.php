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
                            <h6>Contact Page</h6>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="d-flex justify-content-center">

                                    @include('admin.web.contact.add_contact')

                                </div>
                            </div>
                        </div>

                        @php
                            $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg'];
                            $videoExtensions = ['mp4', 'webm', 'ogg'];

                            $isImage = Str::endsWith($contact->img, $imageExtensions);
                            $isVideo = Str::endsWith($contact->img, $videoExtensions);
                        @endphp

                        <div class="card-body px-auto pt-0 pb-2">
                            <div class="row mt-4">
                                <div class="col-12 d-block text-center m-auto">
                                    <label for="">
                                        Image or Video
                                        <span class="text-danger fw-light fs-xs">
                                            *1200x800*
                                        </span>
                                    </label>

                                    @if($isImage)
                                        <img src="{{ $contact->img }}" class="d-block m-auto" alt="" style="max-width: 100%; height: auto;">
                                    @elseif($isVideo)
                                        <iframe src="{{ $contact->img }}" frameborder="0" allowfullscreen style="width: 100%; height: auto;"></iframe>
                                    @else
                                        <p>Unsupported media type.</p>
                                    @endif
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
