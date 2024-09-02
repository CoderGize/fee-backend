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
                            <a href="{{ route('admin.subcategories.create') }}" class="btn btn-primary btn-sm float-end">Add New Subcategory</a>
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
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Category</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Image</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($subcategories as $subcategory)
                                            <tr>
                                                <td class="text-sm">{{ $subcategory->name }}</td>
                                                <td class="text-sm">{{ $subcategory->name_ar }}</td>
                                                <td class="text-sm">{{ $subcategory->description }}</td>
                                                <td class="text-sm">{{ $subcategory->description_ar }}</td>
                                                <td class="text-sm">{{ $subcategory->category->name }}</td>
                                                <td class="text-sm">
                                                    @if ($subcategory->image)
                                                        <img src="{{ asset($subcategory->image) }}" alt="Subcategory Image" width="50">
                                                    @else
                                                        No Image
                                                    @endif
                                                </td>
                                                <td class="px-3">
                                                    <a href="{{ route('admin.subcategories.edit', $subcategory->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                                    <form action="{{ route('admin.subcategories.destroy', $subcategory->id) }}" method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this subcategory?');">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
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
