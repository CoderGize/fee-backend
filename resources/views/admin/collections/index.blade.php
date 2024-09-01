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
                            <a href="{{ route('admin.collections.create') }}" class="btn btn-primary">Create New Collection</a>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <script>
                                setTimeout(function() {
                                    $('.alert-success').fadeOut('slow');
                                }, 5000);
                            </script>
                        @endif
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name (EN)</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name (AR)</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Description (EN)</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Description (AR)</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Image</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($collections as $collection)
                                            <tr>
                                                <td class="text-sm">{{ $collection->name_en }}</td>
                                                <td class="text-sm">{{ $collection->name_ar }}</td>
                                                <td class="text-sm">{{ $collection->description_en }}</td>
                                                <td class="text-sm">{{ $collection->description_ar }}</td>
                                                <td class="text-sm">
                                                    @if ($collection->image)
                                                        <img src="{{ asset($collection->image) }}" alt="Collection Image" width="50">
                                                    @else
                                                        No Image
                                                    @endif
                                                </td>
                                                <td class="text-sm">
                                                    <a href="{{ route('admin.collections.edit', $collection->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                    <form action="{{ route('admin.collections.destroy', $collection->id) }}" method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this collection?')">Delete</button>
                                                    </form>
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
