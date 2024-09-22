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
                            <h6>Subcategories List</h6>

                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="d-flex justify-content-center">

                                    @include('admin.subcategories.create')

                                </div>
                            </div>
                        </div>

                        <div class="row mt-1 px-4">
                            <div class="col-12 d-flex justify-content-end align-items-center">
                                <form method="GET" action="{{ route('admin.subcategories.index') }}" class="d-flex">
                                    <div class="form-group mb-0 me-2">
                                        <input type="text" name="search" class="form-control" placeholder="Search subcategory..."
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
                                <table class="table align-items-center text-center mb-0">
                                    <thead>
                                         <tr>
                                             <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Image</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                <img src="/img/en.png" width="15px" alt="">
                                                Name
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                <img src="/img/ar.png" width="15px" alt="">
                                                Name
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                <img src="/img/en.png" width="15px" alt="">
                                                Description
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                <img src="/img/ar.png" width="15px" alt="">
                                                Description
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Category</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($subcategories as $data)
                                            <tr>
                                                <td class="text-sm">
                                                    @if ($data->image)
                                                        <img src="{{ $data->image }}" alt="Subcategory Image" width="50">
                                                    @else
                                                       <p class="text-danger">
                                                        No Image
                                                       </p>
                                                    @endif
                                                </td>
                                                <td class="text-sm">{{ $data->name }}</td>
                                                <td class="text-sm">{{ $data->name_ar }}</td>
                                                <td class="text-sm">{{ $data->description }}</td>
                                                <td class="text-sm">{{ $data->description_ar }}</td>
                                                <td class="text-sm">{{ $data->category->name }}</td>

                                                <td>
                                                    @include('admin.subcategories.edit')
                                                </td>

                                                <td class="text-sm ">
                                                    <a href="{{ route('admin.subcategories.destroy', $data->id) }}" class="text-danger font-weight-bold text-xs text-center m-auto" data-toggle="tooltip" title="Delete Designer" onclick="return confirm('Are you sure you want to delete this Subcategory?')">
                                                        Delete <i class="bi bi-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-danger font-weight-bold">No Subcategory Found!</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
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
