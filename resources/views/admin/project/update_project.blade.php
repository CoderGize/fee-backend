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
                            <a href="{{ url('/admin/show_project') }}" class="btn btn-dark">
                                <i class="bi bi-arrow-left"></i>
                                back
                            </a>
                        </div>
                        <div class="card-body px-auto pt-0 pb-2">
                            <form action="{{ url('/admin/update_project_confirm', $project->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="mt-4 row">
                                    <div class="col-4">
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">
                                                Title
                                            </label>
                                            <input type="text" name="title" value="{{ $project->title }}"
                                                class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">
                                                Date
                                            </label>
                                            <input type="date" name="date" value="{{ $project->date }}"
                                                class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">
                                                Client
                                            </label>
                                            <input type="text" name="client" value="{{ $project->client }}"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">

                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">
                                                Service
                                            </label>
                                            <textarea name="service" required id="" cols="30" rows="15" class="form-control">{{ $project->service }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">
                                                Description
                                            </label>
                                            <textarea name="description" required id="" cols="30" rows="15" class="form-control">{{ $project->description }}</textarea>
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
