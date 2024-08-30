<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.css')
</head>

<body class="g-sidenav-show   bg-gray-100">

    @include('admin.sidebar')
    <main class="main-content position-relative border-radius-lg ">
        <!-- Navbar -->
        @include('admin.navbar')
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0 ">
                            <a href="{{ url('/admin/show_blog') }}" class="btn btn-dark">
                                <i class="bi bi-arrow-left"></i>
                                back
                            </a>
                        </div>
                        <div class="card-body px-auto pt-0 pb-2">
                            <form action="{{ url('/admin/update_blog_confirm', $blog->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="mt-4 row">
                                    <div class="col-12">
                                        <div class="mb-3 text-center">
                                            <label for="exampleInputPassword1" class="form-label">
                                                Image
                                            </label>
                                            <img class="d-block m-auto" width="150px" src="/blog/{{ $blog->img }}"
                                                alt="">
                                            <input type="file" name="img" value="{{ $blog->img }}"
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 row">

                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">
                                                Title
                                            </label>
                                            <input type="text" name="title" value="{{ $blog->title }}"
                                                class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">
                                                Subtitle
                                            </label>
                                            <input type="text" name="subtitle" value="{{ $blog->subtitle }}"
                                                class="form-control" required>
                                        </div>
                                    </div>

                                </div>

                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">
                                                Text
                                            </label>
                                            <textarea name="text" required id="" cols="30" rows="15" class="form-control">{{ $blog->text }}</textarea>
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
            @include('admin.footer')
        </div>
    </main>

    @include('admin.script')

</body>

</html>
