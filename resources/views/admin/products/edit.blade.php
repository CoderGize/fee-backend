{{-- resources/views/admin/products/edit.blade.php --}}

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
                            <a href="{{ route('admin.products.index') }}" class="btn btn-dark">
                                <i class="bi bi-arrow-left"></i>
                                Back
                            </a>
                            <h6>Edit Product</h6>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="card-body px-auto pt-0 pb-2">
                            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row mt-4">
                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">
                                                <img src="/img/en.png" width="15px" alt="">
                                                Product Name
                                            </label>
                                            <input type="text" name="name" class="form-control" id="name" value="{{ $product->name }}" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="name_ar" class="form-label">
                                                <img src="/img/ar.png" width="15px" alt="">
                                                Product Name
                                            </label>
                                            <input type="text" name="name_ar" class="form-control" id="name_ar" value="{{ $product->name_ar }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                  <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                                <label for="style_number" class="form-label">Style Number</label>
                                                <input type="text" name="style_number" class="form-control" id="style_number" value="{{ $product->style_number }}" required>
                                            </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                      <div class="mb-3">
                                            <label for="tags" class="form-label">Tags</label>
                                            <select name="tags[]" id="tags" class="form-control" multiple>
                                                @if(is_array($product->tags) && !empty($product->tags))
                                                    @foreach($product->tags as $tag)
                                                        <option value="{{ $tag }}" selected>{{ $tag }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="price" class="form-label">Price</label>
                                            <input type="number" name="price" class="form-control" id="price" step="0.01" value="{{ $product->price }}" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="sale_price" class="form-label">Sale Price</label>
                                            <input type="number" name="sale_price" class="form-control" id="sale_price" step="0.01" value="{{ $product->sale_price }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="discount_status" class="form-label">Discount Status</label>
                                            <select name="discount_status" class="form-control" id="discount_status">
                                                <option value="0" {{ $product->discount_status == 0 ? 'selected' : '' }}>Inactive</option>
                                                <option value="1" {{ $product->discount_status == 1 ? 'selected' : '' }}>Active</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="discount_percentage" class="form-label">Discount Percentage</label>
                                            <input type="number" name="discount_percentage" class="form-control" id="discount_percentage" max="100" value="{{ $product->discount_percentage }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                  <div class="col-12 col-sm-6">
                                      <div class="mb-3">
                                            <label for="sizes" class="form-label">Sizes</label>
                                            <select name="sizes[]" id="sizes" class="form-control" multiple>
                                                @if(is_array($product->sizes) && !empty($product->sizes))
                                                    @foreach($product->sizes as $size)
                                                        <option value="{{ $size }}" selected>{{ $size }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                </div>


                                <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                            <label for="colors" class="form-label">Colors</label>
                                            <select name="colors[]" id="colors" class="form-control" multiple>
                                                @if(is_array($product->colors) && !empty($product->colors))
                                                    @foreach($product->colors as $color)
                                                        <option value="{{ $color }}" selected>{{ $color }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                </div>

                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="description_en" class="form-label">
                                                <img src="/img/en.png" width="15px" alt="">
                                                Description
                                            </label>
                                            <textarea name="description" class="form-control" id="description">{{ $product->description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="description_ar" class="form-label">
                                                <img src="/img/ar.png" width="15px" alt="">
                                                Description
                                            </label>
                                            <textarea name="description_ar" class="form-control" id="description_ar">{{ $product->description_ar }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="designer_id" class="form-label">Designer</label>
                                            <select name="designer_id" id="designer_id" class="form-control" required>
                                                @foreach($designers as $designer)
                                                    <option value="{{ $designer->id }}" {{ $designer->id == $product->designer_id ? 'selected' : '' }}>{{ $designer->f_name }} {{ $designer->l_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                       <div class="mb-3">
                                            <label for="collections" class="form-label">Collections</label>
                                            <select name="collections[]" id="collections" class="form-control" multiple>
                                                @foreach($collection as $col)
                                                    <option value="{{ $col->id }}" {{ in_array($col->id, $product->collections->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                        {{ $col->name_en }} {{ $col->name_ar }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                     <div class="mb-3">
                                            <label for="categories" class="form-label">Categories</label>
                                            <select name="categories[]" id="categories" class="form-control" multiple>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->name }}" {{ in_array($category->name, $product->categories->pluck('name')->toArray()) ? 'selected' : '' }}>
                                                        {{ $category->name }} {{ $category->name_ar }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                    <div class="mb-3">
                                            <label for="subcategories" class="form-label">Subcategories</label>
                                            <select name="subcategories[]" id="subcategories" class="form-control" multiple>
                                                @foreach($subcategories as $subcategory)
                                                    <option value="{{ $subcategory->id }}" {{ in_array($subcategory->id, $product->subcategories->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                        {{ $subcategory->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="images" class="form-label">Product Images</label>
                                            <input type="file" name="images[]" class="form-control" id="images" multiple onchange="previewImages()">
                                            <small class="form-text text-muted">You can select multiple images to upload.</small>
                                            <div id="image-previews" class="mt-3">
                                                @foreach ($product->images as $image)
                                                    <img src="{{ $image->image_path }}" alt="Product Image" style="height:100px; width:100px;" class="img-thumbnail">
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="quantity" class="form-label">Quantity</label>
                                            <input type="number" name="quantity" class="form-control" id="quantity" step="0.01" value="{{ $product->quantity }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-dark">
                                            <i class="bi bi-pencil"></i>
                                            Update Product
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @include('admin.footer')
        </div>
    </main>
    @include('admin.script')
</body>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Select2 for Tags, Sizes, Colors, Collections, Categories, and Subcategories
    $('#tags').select2({
        tags: true,
        tokenSeparators: [','],
        placeholder: 'Enter Tags'
    });

    $('#sizes').select2({
        tags: true,
        tokenSeparators: [','],
        placeholder: 'Enter Sizes'
    });

    $('#colors').select2({
        tags: true,
        tokenSeparators: [','],
        placeholder: 'Enter Colors'
    });

    $('#collections').select2({
        placeholder: 'Select Collections'
    });

    $('#categories').select2({
        placeholder: 'Select Categories'
    });

    $('#subcategories').select2({
        placeholder: 'Select Subcategories'
    });


    const categorySelect = document.getElementById('categories');
    const subcategorySelect = document.getElementById('subcategories');

    categorySelect.addEventListener('change', function() {
        const selectedCategoryIds = Array.from(categorySelect.selectedOptions).map(option => option.value);

        if (selectedCategoryIds.length > 0) {
            fetch(`/admin/products/subcategories?category_ids=${selectedCategoryIds.join(',')}`)
                .then(response => response.json())
                .then(data => {
                    subcategorySelect.innerHTML = '';
                    data.subcategories.forEach(subcategory => {
                        const option = document.createElement('option');
                        option.value = subcategory.name;
                        option.textContent = subcategory.name;
                        subcategorySelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching subcategories:', error));
        } else {
            subcategorySelect.innerHTML = '';
        }
    });
});
</script>
</html>


