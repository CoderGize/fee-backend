<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.css')
</head>

<body class="g-sidenav-show bg-gray-100">

    @include('admin.sidebar')
    <main class="main-content position-relative border-radius-lg">
        <!-- Navbar -->
        @include('admin.navbar')
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Create New Category</h6>
                        </div>
                        <div class="card-body px-auto pt-0 pb-2">
                        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row mt-4">
                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="name_en" class="form-label">
                                                Name (EN)
                                                <img src="{{ asset('images/flags/us.png') }}" alt="EN" width="20">
                                            </label>
                                            <input type="text" name="name_en" class="form-control" id="name_en" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="name_ar" class="form-label">
                                                Name (AR)
                                                <img src="{{ asset('images/flags/ar.png') }}" alt="AR" width="20">
                                            </label>
                                            <input type="text" name="name_ar" class="form-control" id="name_ar">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="description_en" class="form-label">
                                                Description (EN)
                                                <img src="{{ asset('images/flags/us.png') }}" alt="EN" width="20">
                                            </label>
                                            <textarea name="description_en" class="form-control" id="description_en"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="description_ar" class="form-label">
                                                Description (AR)
                                                <img src="{{ asset('images/flags/ar.png') }}" alt="AR" width="20">
                                            </label>
                                            <textarea name="description_ar" class="form-control" id="description_ar"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Image</label>
                                            <input type="file" name="image" class="form-control" id="image">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn mt-3 btn-primary">Create Category</button>
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
