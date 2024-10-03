<button type="button" class="btn btn-dark mt-4" data-bs-toggle="modal" data-bs-target="#exampleModal">
    <i class="me-2 fs-6 bi bi-pen"></i>
    Update About
</button>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update About
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('/admin/web/update_about') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                            Image
                            <span class="text-danger fw-light fs-xs">
                                *1200x800*
                            </span>
                        </label>
                        <input type="file" name="img" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                            <img src="/img/en.png" width="15px" alt="">
                            About Text
                        </label>
                        <textarea name="about_en" id="" cols="30" class="form-control" rows="3" required>{{ $about->about_en }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                            <img src="/img/ar.png" width="15px" alt="">
                            About Text
                        </label>
                        <textarea name="about_ar" id="" cols="30" class="form-control" rows="3" required>{{ $about->about_ar }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                            <img src="/img/en.png" width="15px" alt="">
                            Our Vision Text
                        </label>
                        <textarea name="vision_en" id="" cols="30" class="form-control" rows="3" required>{{ $about->vision_en }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                            <img src="/img/ar.png" width="15px" alt="">
                            Our Vision Text
                        </label>
                        <textarea name="vision_ar" id="" cols="30" class="form-control" rows="3" required>{{ $about->vision_ar }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                            <img src="/img/en.png" width="15px" alt="">
                            Our Mission Text
                        </label>
                        <textarea name="mission_en" id="" cols="30" class="form-control" rows="3" required>{{ $about->mission_en }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                            <img src="/img/ar.png" width="15px" alt="">
                            Our Mission Text
                        </label>
                        <textarea name="mission_ar" id="" cols="30" class="form-control" rows="3" required>{{ $about->mission_ar }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                            <img src="/img/en.png" width="15px" alt="">
                            Why Us Title
                        </label>
                        <textarea name="whyus_title_en" id="" cols="30" class="form-control" rows="3" required>{{ $about->whyus_title_en }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                            <img src="/img/ar.png" width="15px" alt="">
                            Why Us Title
                        </label>
                        <textarea name="whyus_title_ar" id="" cols="30" class="form-control" rows="3" required>{{ $about->whyus_title_ar }}</textarea>
                    </div>


                    <div class="mb-3">
                        <label for="whyus_text_en" class="form-label">
                            <img src="/img/en.png" width="15px" alt="">
                            Why Us Text (English)
                        </label>

                        <div id="whyus-text-en-container">
                            @foreach($about->whyus_text_en ?? [] as $key => $value)
                            <div class="input-group mb-2">
                                <input type="text" name="whyus_text_en_keys[]" class="form-control" value="{{ $key }}" placeholder="Enter key">
                                <input type="text" name="whyus_text_en_values[]" class="form-control" value="{{ $value }}" placeholder="Enter value">
                                <button type="button" class="btn btn-danger remove-row">Remove</button>
                            </div>
                            @endforeach
                        </div>

                        <button type="button" class="btn btn-success" id="add-whyus-text-en">Add Key-Value Pair</button>
                    </div>


                    <div class="mb-3">
                        <label for="whyus_text_ar" class="form-label">
                            <img src="/img/ar.png" width="15px" alt="">
                            Why Us Text (Arabic)
                        </label>

                        <div id="whyus-text-ar-container">
                            @foreach($about->whyus_text_ar ?? [] as $key => $value)
                            <div class="input-group mb-2">
                                <input type="text" name="whyus_text_ar_values[]" class="form-control" value="{{ $value }}" placeholder="Enter value" dir="rtl">
                                <input type="text" name="whyus_text_ar_keys[]" class="form-control" value="{{ $key }}" placeholder="Enter key" dir="rtl">
                                <button type="button" class="btn btn-danger remove-row">Remove</button>
                            </div>
                            @endforeach
                        </div>

                        <button type="button" class="btn btn-success" id="add-whyus-text-ar">Add Key-Value Pair</button>
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

<script>

document.getElementById('add-whyus-text-en').addEventListener('click', function() {
    const container = document.getElementById('whyus-text-en-container');
    const div = document.createElement('div');
    div.classList.add('input-group', 'mb-2');
    div.innerHTML = `
        <input type="text" name="whyus_text_en_keys[]" class="form-control" placeholder="Enter key">
        <input type="text" name="whyus_text_en_values[]" class="form-control" placeholder="Enter value">
        <button type="button" class="btn btn-danger remove-row">Remove</button>
    `;
    container.appendChild(div);
});


document.getElementById('add-whyus-text-ar').addEventListener('click', function() {
    const container = document.getElementById('whyus-text-ar-container');
    const div = document.createElement('div');
    div.classList.add('input-group', 'mb-2');
    div.innerHTML = `
        <input type="text" name="whyus_text_ar_values[]" class="form-control" placeholder="Enter value">
        <input type="text" name="whyus_text_ar_keys[]" class="form-control" placeholder="Enter key">
        <button type="button" class="btn btn-danger remove-row">Remove</button>
    `;
    container.appendChild(div);
});


document.addEventListener('click', function(e) {
    if (e.target && e.target.classList.contains('remove-row')) {
        e.target.closest('.input-group').remove();
    }
});
</script>
