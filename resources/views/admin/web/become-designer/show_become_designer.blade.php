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
                            <h6>Become a Designer Section</h6>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="d-flex justify-content-center">

                                    @include('admin.web.become-designer.update_become_designer')

                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12 col-sm-6 d-block m-auto text-center">
                                <label for="" class="d-block">
                                    <img src="/img/en.png" width="15px" alt="">
                                    Text
                                </label>
                                <p>{{ $becomedesigner->text_en }}</p>
                            </div>
                            <div class="col-12 col-sm-6 d-block m-auto text-center">
                                <label for="" class="d-block">
                                    <img src="/img/ar.png" width="15px" alt="">
                                    Text
                                </label>
                                <p>{{ $becomedesigner->text_ar }}</p>
                            </div>

                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="d-flex justify-content-center">

                                    @include('admin.web.become-designer.add_become_designer')

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
                                                <img src="/img/en.png" width="15px" alt="">
                                                Text
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                <img src="/img/ar.png" width="15px" alt="">
                                                Text
                                            </th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($becomedesignerbenefit as $data)
                                            <tr class="text-center">
                                                <td>
                                                    <p>{{ $data->point_en }}</p>
                                                </td>

                                                <td>
                                                    <p>{{ $data->point_ar }}</p>
                                                </td>

                                                <td class="align-middle">
                                                    <a href="{{ url('admin/web/delete_become_designer', $data->id) }}"
                                                        class="text-danger font-weight-bold text-xs"
                                                        data-toggle="tooltip" data-original-title="Edit feature point"
                                                        onclick="return confirm('Are you sure you want to delete this feature point?')">
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
                                {{ $becomedesignerbenefit->render('admin.web.pagination') }}
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
