<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.css')
</head>
<body class="g-sidenav-show bg-gray-100">
    @include('admin.sidebar')

    <main class="main-content position-relative border-radius-lg">
        @include('admin.navbar')

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Collections</h6>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="d-flex justify-content-center">

                                    @include('admin.collections.create')

                                </div>
                            </div>
                        </div>

                        <div class="row mt-1 px-4">
                            <div class="col-12 d-flex justify-content-end align-items-center">
                                <form method="GET" action="{{ route('admin.categories.index') }}" class="d-flex">
                                    <div class="form-group mb-0 me-2">
                                        <input type="text" name="search" class="form-control" placeholder="Search collections..."
                                            value="{{ request()->search }}">
                                    </div>

                                    <div class="form-group mb-0 me-2">
                                        <select name="per_page" class="form-control">
                                            <option value="10" {{ request()->per_page == 10 ? 'selected' : '' }}>10 per page</option>
                                            <option value="25" {{ request()->per_page == 25 ? 'selected' : '' }}>25 per page</option>
                                            <option value="50" {{ request()->per_page == 50 ? 'selected' : '' }}>50 per page</option>
                                        </select>
                                    </div>

                                    <div>
                                        <button type="submit" class="btn btn-primary">Apply</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0 text-center">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Image</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                <img src="/img/en.png" width="15px" alt="">
                                                Name
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                <img src="/img/ar.png" width="15px" alt="">
                                                Name (AR)
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                <img src="/img/en.png" width="15px" alt="">
                                                Description (EN)
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                <img src="/img/ar.png" width="15px" alt="">
                                                Description (AR)
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($collections as $data)
                                            <tr>
                                                <td class="text-sm">
                                                    @if ($data->image)
                                                        <img src="{{ $data->image }}" alt="Collection Image" width="50">
                                                    @else
                                                        <p class="text-danger">No Image</p>
                                                    @endif
                                                </td>
                                                <td class="text-sm">{{ $data->name_en }}</td>
                                                <td class="text-sm">{{ $data->name_ar }}</td>
                                                <td class="text-sm">{{ $data->description_en }}</td>
                                                <td class="text-sm">{{ $data->description_ar }}</td>

                                                <td class="text-sm">
                                                    @include('admin.collections.edit')
                                                </td>

                                                <td class="text-sm ">
                                                    <a href="{{ route('admin.collections.destroy', $data->id) }}" class="text-danger font-weight-bold text-xs text-center m-auto" data-toggle="tooltip" title="Delete Designer" onclick="return confirm('Are you sure you want to delete this Designer?')">
                                                        Delete <i class="bi bi-trash"></i>
                                                    </a>
                                                </td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-danger font-weight-bold">No Collections Found!</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                {{ $collections->links() }} <!-- Add pagination links if needed -->
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
