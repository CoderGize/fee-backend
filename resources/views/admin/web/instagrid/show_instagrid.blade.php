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
                            <h6>Instagram Grid Section</h6>
                        </div>

                        <div class="row mb-3">

                            <div class="col-12">
                                <div class="d-flex justify-content-center">

                                    @if ($insta_count < 10)
                                        @include('admin.web.instagrid.add_instagrid')
                                    @else
                                        <h5 class="my-5 text-danger">
                                            You have reached the maximum limit of posts.
                                            <span class="text-sm text-danger">(delete some)</span>
                                        </h5>
                                    @endif

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
                                                Image
                                                <span class="text-danger fw-light fs-xs">
                                                    *1080x1080*
                                                </span>
                                            </th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($instagrid as $data)
                                            <tr class="text-center">
                                                <td>
                                                    <img src="{{ $data->img }}" class="w-25" alt="">
                                                </td>

                                                <td class="align-middle">
                                                    <a href="{{ url('admin/web/delete_instagrid', $data->id) }}"
                                                        class="text-danger font-weight-bold text-xs"
                                                        data-toggle="tooltip" data-original-title="Edit skill"
                                                        onclick="return confirm('Are you sure you want to delete this skill?')">
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
                                {{-- {{ $instagrid->render('admin.web.pagination') }} --}}
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
