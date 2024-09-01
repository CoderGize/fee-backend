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
                            <h6>Create New Collection</h6>
                        </div>
                        <div class="card-body px-auto pt-0 pb-2">
                            <form action="{{ route('admin.collections.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row mt-4">
                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="name_en" class="form-label">
                                                Name (EN)
                                                <img src="{{ asset('flags/en.png') }}" alt="English Flag" width="20" style="vertical-align: middle;">
                                            </label>
                                            <input type="text" name="name_en" class="form-control @error('name_en') is-invalid @enderror" id="name_en" placeholder="Enter English name" required>
                                            @error('name_en')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="name_ar" class="form-label">
                                                Name (AR)
                                                <img src="{{ asset('flags/ar.png') }}" alt="Arabic Flag" width="20" style="vertical-align: middle;">
                                            </label>
                                            <input type="text" name="name_ar" class="form-control @error('name_ar') is-invalid @enderror" id="name_ar" placeholder="Enter Arabic name">
                                            @error('name_ar')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="description_en" class="form-label">
                                                Description (EN)
                                                <img src="{{ asset('flags/en.png') }}" alt="English Flag" width="20" style="vertical-align: middle;">
                                            </label>
                                            <textarea name="description_en" class="form-control @error('description_en') is-invalid @enderror" id="description_en" placeholder="Enter English description"></textarea>
                                            @error('description_en')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="description_ar" class="form-label">
                                                Description (AR)
                                                <img src="{{ asset('flags/ar.png') }}" alt="Arabic Flag" width="20" style="vertical-align: middle;">
                                            </label>
                                            <textarea name="description_ar" class="form-control @error('description_ar') is-invalid @enderror" id="description_ar" placeholder="Enter Arabic description"></textarea>
                                            @error('description_ar')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
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
                                    <button type="submit" class="btn mt-3 btn-primary">Create Collection</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('admin.script')

</body>

</html>
