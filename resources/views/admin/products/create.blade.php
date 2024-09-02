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
                            <h6>Create New Product</h6>
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
                            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row mt-4">
                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Product Name EN</label>
                                            <input type="text" name="name" class="form-control" id="name" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="name_ar" class="form-label">Product Name AR</label>
                                            <input type="text" name="name_ar" class="form-control" id="name_ar" required>
                                        </div>
                                    </div>

                                </div>
                                <div class="row mt-4">
                                  <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="style_number" class="form-label">Style Number</label>
                                            <input type="text" name="style_number" class="form-control" id="style_number" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">
                                            Tags
                                        </label>
                                        <select class="form-select" name="tags[]" multiple="multiple" aria-label="Select tags">

                                        </select>
                                    </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="price" class="form-label">Price</label>
                                            <input type="number" name="price" class="form-control" id="price" step="0.01" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="sale_price" class="form-label">Sale Price</label>
                                            <input type="number" name="sale_price" class="form-control" id="sale_price" step="0.01">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="discount_status" class="form-label">Discount Status</label>
                                            <select name="discount_status" class="form-control" id="discount_status">
                                                <option value="0">Inactive</option>
                                                <option value="1">Active</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="discount_percentage" class="form-label">Discount Percentage</label>
                                            <input type="number" name="discount_percentage" class="form-control" id="discount_percentage" max="100">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                <div class="col-12 col-sm-6">
                                     <div class="mb-3">
                                               <label for="sizes" class="form-label">Sizes</label>
                                                <select class="form-select" name="sizes[]" id="sizes" multiple="multiple" aria-label="Select sizes">
                                                    <!-- Options will be dynamically added if needed -->
                                                </select>
                                            </div>
                                        </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="colors" class="form-label">Colors</label>
                                            <select class="form-select" name="colors[]" id="colors" multiple="multiple" aria-label="Select colors">
                                                <!-- Options will be dynamically added if needed -->
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="description_en" class="form-label">Description EN</label>
                                            <textarea name="description" class="form-control" id="description"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="description_ar" class="form-label">Description  AR</label>
                                            <textarea name="description_ar" class="form-control" id="description_ar"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="designer_id" class="form-label">Designer</label>
                                            <select name="designer_id" id="designer_id" class="form-control" required>
                                                @foreach($designers as $designer)
                                                    <option value="{{ $designer->id }}">{{ $designer->f_name }} {{ $designer->l_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="collections" class="form-label">Collections</label>
                                            <select name="collections[]" id="collections" class="form-control" multiple="multiple">
                                                @foreach($collection as $col)
                                                    <option value="{{ $col->id }}">{{ $col->name_en }} {{ $col->name_ar }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="categories" class="form-label">Categories</label>
                                            <select name="categories[]" id="categories" class="form-control" multiple="multiple">
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }} {{ $category->name_ar }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="subcategories" class="form-label">Subcategories</label>
                                            <select name="subcategories[]" id="subcategories" class="form-control" multiple="multiple">
                                                <!-- Subcategories will be dynamically loaded based on selected categories -->
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="images" class="form-label">Product Images</label>
                                            <input type="file" name="images[]" class="form-control" id="images" multiple onchange="previewImages()">
                                            <small class="form-text text-muted">You can select multiple images to upload.</small>
                                            <div id="image-previews" class="mt-3"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn mt-3 btn-primary">Create Product</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @include('admin.footer')
        </div>
    </main>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



<script>
   $(document).ready(function() {
    $('select[name="tags[]"]').select2({
            tags: true,
            placeholder: 'add a tag',
            tokenSeparators: [',']
        });
        $('#sizes').select2({
            tags: true,
            tokenSeparators: [','],
            placeholder: 'add a size',
            allowClear: true
        });

        $('#colors').select2({
            tags: true,
            tokenSeparators: [','],
            placeholder: 'add a color',
            allowClear: true
        });
        $('#collections').select2({
            placeholder: 'Select collections',
            allowClear: true,
            width: '100%'
        });
    $('#categories').select2({
        placeholder: 'Select categories',
        allowClear: true,
        width: '100%'
    });

    $('#subcategories').select2({
        placeholder: 'Select subcategories',
        allowClear: true,
        width: '100%'
    });

    const categorySelect = $('#categories');
    const subcategorySelect = $('#subcategories');


    categorySelect.on('change', function () {
        const selectedCategoryIds = categorySelect.val();

        if (selectedCategoryIds && selectedCategoryIds.length > 0) {
            $.ajax({
                url: `/admin/products/subcategories?category_ids=${selectedCategoryIds.join(',')}`,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    subcategorySelect.empty();
                    data.subcategories.forEach(function(subcategory) {
                        const option = new Option(subcategory.name, subcategory.id, false, false);
                        subcategorySelect.append(option);
                    });
                    subcategorySelect.trigger('change');
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching subcategories:', error);
                }
            });
        } else {
            subcategorySelect.empty();
        }
    });
});

</script>
    <script>

        function previewImages() {
            const preview = document.getElementById('image-previews');
            preview.innerHTML = '';
            const files = document.getElementById('images').files;
            for (const file of files) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '100px';
                    img.style.height = '100px';
                    img.style.marginRight = '10px';
                    preview.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        }




        </script>
    @include('admin.script')
</body>
</html>
