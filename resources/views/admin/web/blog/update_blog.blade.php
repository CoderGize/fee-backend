<!DOCTYPE html>
<html lang="en">

<head>
<meta name="csrf-token" content="{{ csrf_token() }}">

    @include('admin.web.css')
</head>

<body class="g-sidenav-show   bg-gray-100">

    @include('admin.web.sidebar')
    <main class="main-content position-relative border-radius-lg ">
        <!-- Navbar -->
        @include('admin.web.navbar')
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0 ">
                            <a href="{{ url('/admin/web/show_blog') }}" class="btn btn-dark">
                                <i class="bi bi-arrow-left"></i>
                                back
                            </a>
                        </div>
                        <div class="card-body px-auto pt-0 pb-2">
                            <form action="{{ url('/admin/web/update_blog_confirm', $blog->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="mt-4 row">
                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3 text-center">
                                            <label for="exampleInputPassword1" class="form-label">
                                                Image
                                            </label>
                                            <img class="d-block m-auto" width="150px" src="{{ $blog->img }}"
                                                alt="">
                                            <input type="file" name="img" value="{{ $blog->img }}"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3 text-center">
                                            <label for="exampleInputPassword1" class="form-label">
                                                Profile
                                            </label>
                                            <img class="d-block m-auto" width="150px" src="{{ $blog->profile }}"
                                                alt="">
                                            <input type="file" name="profile" value="{{ $blog->profile }}"
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 row">

                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">
                                                Link
                                                <i class="bi bi-link"></i>
                                            </label>
                                            <input type="text" name="link" value="{{ $blog->link }}"
                                                class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">
                                                Date
                                            </label>
                                            <input type="date" name="date" value="{{ \Carbon\Carbon::parse($blog->date)->format('Y-m-d') }}" class="form-control" required>
                                        </div>
                                    </div>

                                </div>

                                <div class="mt-4 row">

                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">
                                                <img src="/img/en.png" width="15px" alt="">
                                                Name
                                            </label>
                                            <input type="text" name="name_en" value="{{ $blog->name_en }}"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">
                                                <img src="/img/ar.png" width="15px" alt="">
                                                Name
                                            </label>
                                            <input type="text" name="name_ar" value="{{ $blog->name_ar }}"
                                                class="form-control" required>
                                        </div>
                                    </div>

                                </div>

                                <div class="mt-4 row">

                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">
                                                <img src="/img/en.png" width="15px" alt="">
                                                Title
                                            </label>
                                            <input type="text" name="title_en" value="{{ $blog->title_en }}"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">
                                                <img src="/img/ar.png" width="15px" alt="">
                                                Title
                                            </label>
                                            <input type="text" name="title_ar" value="{{ $blog->title_ar }}"
                                                class="form-control" required>
                                        </div>
                                    </div>

                                </div>
                                <div class="mt-4 row">

                                <div class="col-12 col-sm-6">
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">
                                            <img src="/img/en.png" width="15px" alt="">
                                           Sub Title
                                        </label>
                                        <input type="text" name="sub_title_en" value="{{ $blog->sub_title_en }}"
                                            class="form-control" >
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">
                                            <img src="/img/ar.png" width="15px" alt="">
                                           Sub Title
                                        </label>
                                        <input type="text" name="sub_title_ar" value="{{ $blog->sub_title_en }}"
                                            class="form-control" >
                                    </div>
                                </div>

                                </div>
                                <div class="mt-4 row">

                                    <div class="col-12 col-sm-6">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">
                                            <img src="/img/en.png" width="15px" alt="">
                                            Paragraph 1
                                        </label>
                                        <textarea name="content_en_1" id="content" class="form-control" rows="10">{{ old('content_en_1', $blog->content_en_1) }}</textarea>
                                    </div>

                                    </div>
                                    <div class="col-12 col-sm-6">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">
                                            <img src="/img/ar.png" width="15px" alt="">
                                            Paragraph 1
                                        </label>
                                        <textarea name="content_ar_1" id="content_1" class="form-control" rows="10">{{ old('content_ar_1', $blog->content_ar_1) }}</textarea>
                                    </div>
                                    </div>

                                </div>
                                <div class="mt-4 row">

                                    <div class="col-12 col-sm-6">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">
                                            <img src="/img/en.png" width="15px" alt="">
                                            Paragraph 2
                                        </label>
                                        <textarea name="content_en_2" id="content_2" class="form-control" rows="10">{{ old('content_en_2', $blog->content_en_2) }}</textarea>
                                    </div>

                                    </div>
                                    <div class="col-12 col-sm-6">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">
                                            <img src="/img/ar.png" width="15px" alt="">
                                            Paragraph 2
                                        </label>
                                        <textarea name="content_ar_2" id="content_3" class="form-control" rows="10">{{ old('content_ar_2', $blog->content_ar_2) }}</textarea>
                                    </div>
                                    </div>

                                </div>
                                <div class="mt-4 row">

                                <div class="mb-3">
                                            <label for="images" class="form-label">Paragraph Images</label>
                                            <input type="file" name="images[]" class="form-control" id="images" multiple onchange="previewImages()">
                                            <small class="form-text text-muted">You can select multiple images to upload.</small>
                                            <div id="image-previews" class="mt-3">
                                            @if ($blog->blog_images && is_array($blog->blog_images))
                                                @if (count($blog->blog_images) > 0)
                                                    <div>
                                                        @foreach ($blog->blog_images as $image)
                                                            @if (is_string($image))
                                                                <div style="display: inline-block; margin-right: 10px;">
                                                                    <img src="{{ $image }}" alt="Blog Image" style="height:100px; width:100px;" class="img-thumbnail">

                                                                    <button type="button" class="btn btn-danger" data-image-url="{{ $image }}" data-id="{{ $blog->id }}" onclick="deleteImage(this)">
                                                                        <i class="bi bi-trash"></i>
                                                                    </button>
                                                                </div>
                                                            @elseif (is_array($image) && isset($image[0]))
                                                                <div style="display: inline-block; margin-right: 10px;">
                                                                    <img src="{{ $image[0] }}" alt="Blog Image" style="height:100px; width:100px;" class="img-thumbnail">

                                                                    <button type="button" class="btn btn-danger" data-image-url="{{ $image[0] }}" data-id="{{ $blog->id }}" onclick="deleteImage(this)">
                                                                        <i class="bi bi-trash"></i>
                                                                    </button>
                                                                </div>
                                                            @else
                                                                <p>Invalid image data.</p>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <p>No images available to display.</p>
                                                @endif
                                            @else
                                                <p>No images available to display.</p>
                                            @endif





                                            </div>


                                        </div>

                                    </div>

                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn mt-3 btn-dark">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @include('admin.web.footer')
        </div>
    </main>

    @include('admin.web.script')
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
            var notificationArea = document.getElementById('cke_notifications_area_content');
            var notificationAreaContent = document.getElementsByClassName('cke_notifications_area');
            if (notificationArea) {
                notificationArea.style.display = 'none';
                notificationAreaContent.style.display = 'none';
            }

        setTimeout(function() {
            var notificationArea = document.getElementById('cke_notifications_area_content');
            var notificationAreaContent = document.getElementsByClassName('cke_notifications_area');
            if (notificationArea) {
                notificationArea.style.display = 'none';
                notificationAreaContent.style.display = 'none';
            }
        }, 1000);
    });

    CKEDITOR.editorConfig = function( config ) {
    config.versionCheck = false;
};
    CKEDITOR.replace('content');
    CKEDITOR.replace('content_1');
    CKEDITOR.replace('content_2');
    CKEDITOR.replace('content_3');
    function deleteImage(button) {
    const imageUrl = button.getAttribute('data-image-url');
    const blogId = button.getAttribute('data-id');

    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        console.error('CSRF token not found in the document.');
        return;
    }

    if (confirm('Are you sure you want to delete this image?')) {
        // Make the AJAX request to delete the image
        fetch(`{{ url('/admin/web/blog_image_remove') }}/${blogId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken.getAttribute('content')
            },
            body: JSON.stringify({
                image_url: imageUrl,
                blog_id: blogId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Successfully deleted the image, now remove the image from the UI
                button.parentElement.remove(); // Removes the entire div containing the image and button
            } else {
                alert('Error: Could not delete image.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
}


</script>
<script>

    function previewImages() {
        const preview = document.getElementById('image-previews');
        const files = document.getElementById('images').files;
        for (const file of files) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = '100px';
                img.style.height = '100px';
                img.style.marginRight = '10px';

                const removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.style.background = 'none';
                removeButton.style.border = 'none';
                const removeIcon = document.createElement('i');
                removeIcon.className = 'bi bi-trash';
                removeButton.appendChild(removeIcon);
                removeButton.style.cursor = 'pointer';
                removeButton.onclick = function() {
                    // Remove the image and the button
                    const imageContainer = img.parentNode;
                    imageContainer.remove();

                    // Remove the corresponding file from the input
                    const fileInput = document.getElementById('images');
                    const filesArray = Array.prototype.slice.call(fileInput.files);
                    const index = filesArray.indexOf(file);
                    filesArray.splice(index, 1);
                    fileInput.files = filesArray;
                };

                const imageContainer = document.createElement('div');
                imageContainer.appendChild(img);
                imageContainer.appendChild(removeButton);

                preview.appendChild(imageContainer);
            };
            reader.readAsDataURL(file);
        }
    }
</script>

</body>

</html>
