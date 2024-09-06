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

            {{-- Products Table --}}
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>All Products</h6>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <div class="d-flex justify-content-center">

                            <a href="{{url('/admin/products/create')}}" class="btn btn-dark mt-4">
                                <i class="me-2 fs-6 bi bi-plus-lg"></i>
                                Add a Product
                            </a>

                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    {{-- Table Responsive --}}
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 text-center">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        #
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Image
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Discount Status
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Discount
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Name EN
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Style Number
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Price
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Sale Price
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Tags
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Sizes
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Colors
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Designer
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Collection
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Categories
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Subcategories
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
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
                                                <img src="{{ $product->images->first()->image_path }}" alt="{{ $product->name }}" class="product-image">
                                            @else
                                                <span class="text-danger">No Image</span>
                                            @endif
                                        </td>
                                        <td>{{ $product->discount_status }}</td>
                                        <td>{{ $product->discount_percentage }} %</td>

                                        <td>{{ $product->name }}</td>

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


                                        <td>
                                            <a href="{{ route('admin.products.show', $product->id) }}" class="text-primary">
                                                <i class="bi bi-eye"></i> View
                                            </a>

                                        </td>

                                        <td>
                                            <a href="{{ route('admin.products.edit', $product->id) }}" class="text-success">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>

                                        </td>

                                        <td>
                                            <a href="{{ route('admin.products.destroy', $product->id) }}" class="text-danger">
                                                <i class="bi bi-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    {{-- No Products Found --}}
                                    <tr>
                                        <td colspan="18" class="text-center text-danger font-weight-bold">No Collections Found!</td>
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
