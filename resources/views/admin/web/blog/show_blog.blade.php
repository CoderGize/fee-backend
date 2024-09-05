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
                            <h6>Blog Section</h6>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12 d-flex justify-content-center">
                                <form action="/admin/web/blog_show" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-check form-switch">
                                        <input
                                            class="form-check-input {{ $show->blog_sh == 1 ? 'bg-success' : 'bg-danger' }}"
                                            type="checkbox" role="switch" id="flexSwitchCheckDefault"
                                            onchange="this.form.submit()" value="{{ $show->blog_sh == 1 ? '0' : '1' }}"
                                            name="datash" {{ $show->blog_sh == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="flexSwitchCheckDefault">Show
                                            Section</label>
                                    </div>
                                </form>
                            </div>
                            <div class="col-12">
                                <div class="d-flex justify-content-center">

                                    @include('admin.web.blog.add_blog')

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
                                                Blog Image
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Profile Image
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Name
                                            </th>
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
                                                Link
                                            </th>
                                            <th class="text-secondary opacity-7"></th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($blog as $data)
                                            <tr class="text-center">
                                                <td>
                                                    <img src="{{ $data->img }}" class="w-25" alt="">
                                                </td>

                                                <td>
                                                    <img src="{{ $data->profile }}" class="w-25" alt="">
                                                </td>

                                                <td>
                                                    <p class="text-xs text-truncate font-weight-bold mb-0">
                                                        {{ $data->name_en }}
                                                    </p>
                                                </td>

                                                <td>
                                                    <p class="text-xs text-truncate font-weight-bold mb-0">
                                                        {{ $data->title_en }}
                                                    </p>
                                                </td>

                                                <td>
                                                    <p class="text-xs text-truncate font-weight-bold mb-0">
                                                        {{ $data->date }}
                                                    </p>
                                                </td>

                                                <td>
                                                    <a href="{{$data->link}}" target="_blank" class="text-primary">
                                                        Link
                                                        <i class="bi bi-link"></i>
                                                    </a>
                                                </td>

                                                <td>
                                                    <a href="{{ url('/admin/web/update_blog', $data->id) }}"
                                                        class="text-xs text-success">
                                                        <i class="bi bi-pencil text-xs text-success"></i>
                                                        Edit
                                                    </a>
                                                </td>

                                                <td class="align-middle">
                                                    <a href="{{ url('admin/web/delete_blog', $data->id) }}"
                                                        class="text-danger font-weight-bold text-xs"
                                                        data-toggle="tooltip" data-original-title="delete blog"
                                                        onclick="return confirm('Are you sure you want to delete this blog?')">
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
                                {{ $blog->render('admin.web.pagination') }}
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
