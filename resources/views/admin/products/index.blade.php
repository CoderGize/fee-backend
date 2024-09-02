{{-- resources/views/admin/products/index.blade.php --}}

<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.css') {{-- Include your admin CSS --}}
    <style>
        /* Custom styles for the table and images */
        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }
        .size-item, .color-item {
            display: inline-block;
            background-color: #f1f1f1;
            padding: 5px 10px;
            margin: 2px;
            border-radius: 15px;
            font-size: 0.9em;
        }
        .action-buttons a, .action-buttons form {
            display: inline-block;
            margin-right: 5px;
        }
    </style>
</head>
<body class="g-sidenav-show bg-gray-100">
    @include('admin.sidebar') {{-- Include your admin sidebar --}}

    <main class="main-content position-relative max-height-vh-100 h-100">
        @include('admin.navbar') {{-- Include your admin navbar --}}

        <div class="container-fluid py-4">
            {{-- Success Message --}}
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

            {{-- Error Message --}}
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Header and Create Button --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>Products</h3>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Create New Product</a>
            </div>

            {{-- Products Table --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Product List</h5>
                </div>
                <div class="card-body">
                    {{-- Table Responsive --}}
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Discount Status</th>
                                    <th>Discount</th>
                                    <th>Name EN</th>
                                    <th>Name AR</th>
                                    <th>Style Number</th>
                                    <th>Price</th>
                                    <th>Sale Price</th>
                                    <th>Tags</th>
                                    <th>Sizes</th>
                                    <th>Colors</th>
                                    <th>Designer</th>
                                    <th>Description EN</th>
                                    <th>Description AR</th>
                                    <th>Collection</th>
                                    <th>Categories</th>
                                    <th>Subcategories</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                    <tr>
                                        {{-- Index --}}
                                        <td>{{ ($products->currentPage()-1) * $products->perPage() + $loop->iteration }}</td>

                                        {{-- Product Image --}}
                                        <td>
                                            @if($product->images->count() > 0)
                                                <img src="{{ Storage::url($product->images->first()->image_path) }}" alt="{{ $product->name }}" class="product-image">
                                            @else
                                                <span>No Image</span>
                                            @endif
                                        </td>
                                        <td>{{ $product->discount_status }}</td>
                                        <td>{{ $product->discount_percentage }} %</td>

                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->name_ar }}</td>

                                        <td>{{ $product->style_number }}</td>

                                        <td>${{ number_format($product->price, 2) }}</td>


                                        <td>
                                            @if($product->sale_price)
                                                ${{ number_format($product->sale_price, 2) }}
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>

                                        @if($product->tags)

                                            @foreach($product->tags as $tag)

                                                <span class="tag-item">{{ $tag }}</span>

                                            @endforeach

                                        @else

                                            <span class="text-muted">N/A</span>

                                        @endif

                                        </td>

                                        {{-- Sizes --}}

                                        <td>

                                        @if($product->sizes)

                                            @foreach($product->sizes as $size)

                                                <span class="size-item">{{ $size }}</span>

                                            @endforeach

                                        @else

                                            <span class="text-muted">N/A</span>

                                        @endif

                                        </td>

                                        {{-- Colors --}}

                                        <td>
                                            @if(is_array($product->colors) || is_object($product->colors))
                                                @foreach($product->colors as $color)
                                                    <span class="color-item">{{ $color }}</span>
                                                @endforeach
                                            @elseif($product->colors)
                                                <span class="color-item">{{ $product->colors }}</span>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>


                                        <td>{{ $product->designer->f_name  ?? 'N/A' }}</td>

                                        <td>{{ \Illuminate\Support\Str::limit($product->description, 70) }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($product->description_ar, 70) }}</td>

                                        <td>
                                            @if($product->collections->count() > 0)
                                                @foreach($product->collections as $collection)
                                                    <span class="badge bg-info text-dark">{{ $collection->name_en }}</span>
                                                @endforeach
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($product->categories->count() > 0)
                                                @foreach($product->categories as $category)
                                                    <span class="badge bg-info text-dark">{{ $category->name }}</span>
                                                @endforeach
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>

                                        {{-- Subcategories --}}
                                        <td>
                                            @if($product->subcategories->count() > 0)
                                                @foreach($product->subcategories as $subcategory)
                                                    <span class="badge bg-secondary">{{ $subcategory->name }}</span>
                                                @endforeach
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>

                                        {{-- Actions --}}
                                        <td class="action-buttons">
                                            {{-- Edit Button --}}
                                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>

                                            <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-sm btn-primary">
                                            <i class="bi bi-eye"></i> View
                                            </a>

                                            {{-- Delete Button --}}
                                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    {{-- No Products Found --}}
                                    <tr>
                                        <td colspan="12" class="text-center">No products found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-center mt-4">
                        {{ $products->links('admin.pagination') }}
                    </div>
                </div>
            </div>
        </div>

        @include('admin.footer') {{-- Include your admin footer --}}
    </main>

    @include('admin.script') {{-- Include your admin scripts --}}
</body>
</html>
