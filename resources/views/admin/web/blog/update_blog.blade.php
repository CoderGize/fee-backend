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
                            <a href="{{ url('/admin/web/show_blog') }}" class="btn btn-dark">
                                <i class="bi bi-arrow-left"></i>
                                back
                            </a>
                        </div>
                        <div class="card-body px-auto pt-0 pb-2">
                            <form action="{{ url('/admin/web/update_blog_confirm', $blog->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="mt-4 row">
                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3 text-center">
                                            <label for="exampleInputPassword1" class="form-label">
                                                Image
                                            </label>
                                            <img class="d-block m-auto" width="150px" src="{{ $blog->img }}"
                                                alt="">
                                            <input type="file" name="img" value="{{ $blog->img }}"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3 text-center">
                                            <label for="exampleInputPassword1" class="form-label">
                                                Profile
                                            </label>
                                            <img class="d-block m-auto" width="150px" src="{{ $blog->profile }}"
                                                alt="">
                                            <input type="file" name="profile" value="{{ $blog->profile }}"
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 row">

                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">
                                                Link
                                                <i class="bi bi-link"></i>
                                            </label>
                                            <input type="text" name="link" value="{{ $blog->link }}"
                                                class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">
                                                Date
                                            </label>
                                            <input type="date" name="date" value="{{ \Carbon\Carbon::parse($blog->date)->format('Y-m-d') }}" class="form-control" required>
                                        </div>
                                    </div>

                                </div>

                                <div class="mt-4 row">

                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">
                                                <img src="/img/en.png" width="15px" alt="">
                                                Name
                                            </label>
                                            <input type="text" name="name_en" value="{{ $blog->name_en }}"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">
                                                <img src="/img/ar.png" width="15px" alt="">
                                                Name
                                            </label>
                                            <input type="text" name="name_ar" value="{{ $blog->name_ar }}"
                                                class="form-control" required>
                                        </div>
                                    </div>

                                </div>

                                <div class="mt-4 row">

                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">
                                                <img src="/img/en.png" width="15px" alt="">
                                                Title
                                            </label>
                                            <input type="text" name="title_en" value="{{ $blog->title_en }}"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">
                                                <img src="/img/ar.png" width="15px" alt="">
                                                Title
                                            </label>
                                            <input type="text" name="title_ar" value="{{ $blog->title_ar }}"
                                                class="form-control" required>
                                        </div>
                                    </div>

                                </div>

                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn mt-3 btn-dark">Submit</button>
                                </div>
                            </form>
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
