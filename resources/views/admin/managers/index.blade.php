<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.css')
</head>

<body class="g-sidenav-show bg-gray-100">

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
                            <h6>All Admin</h6>

                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="d-flex justify-content-center">

                                    @include('admin.managers.create')

                                </div>
                            </div>
                        </div>
                        <div class="row mt-1 px-4">
                            <div class="col-12 d-flex justify-content-end align-items-center">
                                <form method="GET" action="{{ route('admin.managers') }}" class="d-flex">
                                    <div class="form-group mb-0 me-2">
                                        <input type="text" name="search" class="form-control" placeholder="Search users..."
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

                        <div class="card-body px-4 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">First Name</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Last Name</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ROLE</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Username</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Profile Image</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created At</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody  >
                                        @forelse ($users as $user)
                                            <tr >
                                                <td class="text-sm">{{ $user->f_name }}</td>
                                                <td class="text-sm">{{ $user->l_name }}</td>
                                                <td class="text-sm">{{ $user->email }}</td>
                                                <td class="text-sm">
                                                <span class="badge bg-info text-dark">{{ $user->role  }}</span>
                                                </td>
                                                <td class="text-sm">{{ $user->username }}</td>
                                                <td class="text-sm">
                                                    @if ($user->image)
                                                        <img src="{{ asset( $user->image) }}" alt="Profile Image" width="50">
                                                    @else
                                                        No Image
                                                    @endif
                                                </td>
                                                <td class="text-sm">{{ $user->created_at->format('Y-m-d') }}</td>
                                                <td class="text-sm">

                                                   @include('admin.managers.edit')

                                                    <a href="{{ url('admin/managers/delete', $user->id) }}" class="text-danger font-weight-bold text-xs" data-toggle="tooltip" title="Delete user" onclick="return confirm('Are you sure you want to delete this user?')">
                                                        Delete <i class="bi bi-trash"></i>
                                                    </a>

                                                </td>


                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-danger font-weight-bold">No Users Found!</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                {{ $users->links('admin.pagination') }}
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
