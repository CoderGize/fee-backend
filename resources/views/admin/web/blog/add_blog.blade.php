<button type="button" class="btn btn-dark mt-4" data-bs-toggle="modal" data-bs-target="#exampleModal">
    <i class="me-2 fs-6 bi bi-plus-lg"></i>
    Add blog
</button>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add blog
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('/admin/web/add_blog') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                            Image
                        </label>
                        <input type="file" name="img" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                            Profile
                        </label>
                        <input type="file" name="profile" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                            Link
                        </label>
                        <input type="text" name="link" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                            <img src="/img/en.png" width="15px" alt="">
                            Name
                        </label>
                        <input type="text" name="name_en" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                            <img src="/img/ar.png" width="15px" alt="">
                            Name
                        </label>
                        <input type="text" name="name_ar" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                            <img src="/img/en.png" width="15px" alt="">
                            Title
                        </label>
                        <input type="text" name="title_en" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                            <img src="/img/ar.png" width="15px" alt="">
                            Title
                        </label>
                        <input type="text" name="title_ar" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                          <img src="/img/en.png" width="15px" alt="">
                            paragraph 1
                        </label>
                        <textarea name="content_ar_1" id="content" class="form-control" rows="10"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                          <img src="/img/ar.png" width="15px" alt="">
                            paragraph 1
                        </label>
                        <textarea name="content_en_1" id="content" class="form-control" rows="10"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                          <img src="/img/en.png" width="15px" alt="">
                            paragraph 2
                        </label>
                        <textarea name="content_ar_2" id="content" class="form-control" rows="10"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                          <img src="/img/ar.png" width="15px" alt="">
                            paragraph 2
                        </label>
                        <textarea name="content_en_2" id="content" class="form-control" rows="10"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="images" class="form-label">Paragraph Images</label>
                        <input type="file" name="images[]" class="form-control" id="images" multiple onchange="previewImages()">
                        <small class="form-text text-muted">You can select multiple images to upload.</small>
                        <div id="image-previews" class="mt-3"></div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                            Date
                        </label>
                        <input type="date" name="date" class="form-control" required>
                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-dark">Add
                        <i class="bi bi-plus-lg"></i>
                    </button>

                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('content');
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
