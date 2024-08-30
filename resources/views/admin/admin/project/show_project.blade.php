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
                        <div class="card-header pb-0">
                            <h6>project Section</h6>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12 d-flex justify-content-center">
                                <form action="/admin/project_show" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-check form-switch">
                                        <input
                                            class="form-check-input bg-black {{ $show->project_sh == 1 ? 'bg-success' : 'bg-danger' }}"
                                            type="checkbox" role="switch" id="flexSwitchCheckDefault"
                                            onchange="this.form.submit()" {{ $show->project_sh == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="flexSwitchCheckDefault">
                                            Show Section
                                        </label>
                                    </div>
                                </form>
                            </div>

                            <div class="col-12">
                                <div class="d-flex justify-content-center">

                                    @include('admin.project.add_project')

                                </div>
                            </div>
                        </div>

                        <div class="card-body px-0 pt-0 mt-4 pb-2">

                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr class="text-center">
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Title
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Date
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Client
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Service
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Description
                                            </th>
                                            <th class="text-secondary opacity-7"></th>
                                            <th class="text-secondary opacity-7"></th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($project as $data)
                                            <tr class="text-center">

                                                <td>
                                                    <p class="text-xs text-truncate font-weight-bold mb-0">
                                                        {{ $data->title }}
                                                    </p>
                                                </td>

                                                <td>
                                                    <p class="text-xs text-truncate font-weight-bold mb-0">
                                                        {{ $data->date }}
                                                    </p>
                                                </td>

                                                <td>
                                                    <p class="text-xs text-truncate font-weight-bold mb-0">
                                                        {{ $data->client }}
                                                    </p>
                                                </td>

                                                <td>
                                                    <p class="text-xs text-truncate font-weight-bold mb-0">
                                                        {{ $data->service }}
                                                    </p>
                                                </td>

                                                <td>
                                                    <p class="text-xs text-truncate font-weight-bold mb-0">
                                                        {{ $data->description }}
                                                    </p>
                                                </td>

                                                <td>
                                                    <a href="{{ url('/admin/show_project_gallery', $data->id) }}"
                                                        class="text-xs text-primary">
                                                        <i class="bi bi-images text-xs text-primary"></i>
                                                        Gallery
                                                    </a>
                                                </td>

                                                <td>
                                                    <a href="{{ url('/admin/update_project', $data->id) }}"
                                                        class="text-xs text-success">
                                                        <i class="bi bi-pencil text-xs text-success"></i>
                                                        Edit
                                                    </a>
                                                </td>

                                                <td class="align-middle">
                                                    <a href="{{ url('admin/delete_project', $data->id) }}"
                                                        class="text-danger font-weight-bold text-xs"
                                                        data-toggle="tooltip" data-original-title="Edit project"
                                                        onclick="return confirm('Are you sure you want to delete this project?')">
                                                        Delete
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="16">
                                                    <p class="text-xs text-center text-danger font-weight-bold mb-0">
                                                        No Data !
                                                    </p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                {{ $project->render('admin.pagination') }}
                            </div>
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
