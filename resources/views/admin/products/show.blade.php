<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.css') {{-- Include your admin CSS --}}
    <style>
        /* Custom styles for the table and images */
        .product-image {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
            margin: auto;
            display: block;
        }

        .product-thumbnails {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 15px;
        }

        .product-thumbnails img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border: 2px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
            transition: border 0.3s ease;
        }

        .product-thumbnails img.active {
            border-color: #007bff;
        }

        .slider-controls {
            display: flex;
            justify-content: space-between;
            width: 100%;
            margin-top: 10px;
        }

        .slider-controls button {
            background-color: #007bff;
            border: none;
            color: white;
            padding: 8px 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .slider-controls button:hover {
            background-color: #0056b3;
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
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header pb-0">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-dark">
                                <i class="bi bi-arrow-left"></i>
                                Back
                            </a>
                            <h6>View Product</h6>
                        </div>
                        <div class="card-body">
                            <h3>{{ $product->name }}</h3>
                            <hr>

                            <div class="product-images mb-3">
                                <img id="mainImage" src="{{ $product->images->isNotEmpty() ? $product->images->first()->image_path : asset('path/to/default-image.jpg') }}" alt="{{ $product->name }}" class="product-image">
                            </div>

                            <div class="slider-controls">
                                <button id="prevBtn"><</button>
                                <button id="nextBtn">></button>
                            </div>

                            <div class="product-thumbnails">
                                @if($product->images->isNotEmpty())
                                    @foreach($product->images as $image)
                                        <img src="{{ $image->image_path }}" alt="{{ $product->name }}" onclick="changeImage(this)">
                                    @endforeach
                                @else
                                    <span>No images available</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body product-details">
                            <div class="detail-item">
                                <span class="detail-label">Price:</span>
                                <span>${{ number_format($product->price, 2) }}</span>
                            </div>
                            @if($product->sale_price)
                                <div class="detail-item">
                                    <span class="detail-label">Sale Price:</span>
                                    <span class="text-danger">${{ number_format($product->sale_price, 2) }}</span>
                                </div>
                            @endif
                            <div class="detail-item">
                                <span class="detail-label">Style Number:</span>
                                <span>{{ $product->style_number }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Quantity:</span>
                                <span>{{ $product->quantity }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Designer:</span>
                                <span>{{ $product->designer->f_name ?? 'N/A' }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Tags:</span>
                                @if($product->tags)
                                    @foreach($product->tags as $tag)
                                        <span class="badge bg-secondary">{{ $tag }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Sizes:</span>
                                @if($product->sizes)
                                    @foreach($product->sizes as $size)
                                        <span class="badge bg-primary">{{ $size }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Colors:</span>
                                @if($product->colors)
                                    @foreach($product->colors as $color)
                                        <span class="badge bg-info">{{ $color }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Description:</span>
                                <p>{{ $product->description }}</p>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Collection:</span>
                                @if($product->collections->count() > 0)
                                    @foreach($product->collections as $collection)
                                        <span class="badge bg-success">{{ $collection->name_en }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Categories:</span>
                                @if($product->categories->count() > 0)
                                    @foreach($product->categories as $category)
                                        <span class="badge bg-warning">{{ $category->name }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Subcategories:</span>
                                @if($product->subcategories->count() > 0)
                                    @foreach($product->subcategories as $subcategory)
                                        <span class="badge bg-warning">{{ $subcategory->name }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('admin.footer')
    </main>

    @include('admin.script')
    <script>
        function changeImage(element) {
            const mainImage = document.getElementById('mainImage');
            mainImage.src = element.src;

            const thumbnails = document.querySelectorAll('.product-thumbnails img');
            thumbnails.forEach(thumb => thumb.classList.remove('active'));

            element.classList.add('active');
        }

        document.getElementById('prevBtn').addEventListener('click', function() {
            const thumbnails = document.querySelectorAll('.product-thumbnails img');
            let activeIndex = Array.from(thumbnails).findIndex(thumb => thumb.classList.contains('active'));
            if (activeIndex > 0) {
                thumbnails[activeIndex].classList.remove('active');
                thumbnails[activeIndex - 1].classList.add('active');
                changeImage(thumbnails[activeIndex - 1]);
            }
        });

        document.getElementById('nextBtn').addEventListener('click', function() {
            const thumbnails = document.querySelectorAll('.product-thumbnails img');
            let activeIndex = Array.from(thumbnails).findIndex(thumb => thumb.classList.contains('active'));
            if (activeIndex < thumbnails.length - 1) {
                thumbnails[activeIndex].classList.remove('active');
                thumbnails[activeIndex + 1].classList.add('active');
                changeImage(thumbnails[activeIndex + 1]);
            }
        });
    </script>
</body>
</html>
