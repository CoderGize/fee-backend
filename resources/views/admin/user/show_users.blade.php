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
                            <h6>All Designers</h6>
                            <a href="{{ route('admin.designer.create') }}" class="btn btn-primary">Add Designer</a>
                        </div>

                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">First Name</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Last Name</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Username</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Profile Image</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created At</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($designers as $designer)
                                            <tr>
                                                <td class="text-sm">{{ $designer->f_name }}</td>
                                                <td class="text-sm">{{ $designer->l_name }}</td>
                                                <td class="text-sm">{{ $designer->email }}</td>
                                                <td class="text-sm">{{ $designer->username }}</td>
                                                <td class="text-sm">
                                                    @if ($designer->image)
                                                        <img src="{{ asset('storage/' . $designer->image) }}" alt="Profile Image" width="50">
                                                    @else
                                                        No Image
                                                    @endif
                                                </td>
                                                <td class="text-sm">{{ $designer->created_at->format('Y-m-d') }}</td>
                                                <td class="text-sm">
                                                    <a href="{{ url('admin/designers/edit', $designer->id) }}" class="text-success font-weight-bold text-xs" data-toggle="tooltip" title="Edit Designer">
                                                        Edit <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <a href="{{ url('admin/designers/delete', $designer->id) }}" class="text-danger font-weight-bold text-xs" data-toggle="tooltip" title="Delete Designer" onclick="return confirm('Are you sure you want to delete this Designer?')">
                                                        Delete <i class="bi bi-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-danger font-weight-bold">No Designers Found!</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                {{ $designers->links('admin.pagination') }}
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
