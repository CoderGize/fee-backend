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
                        <label for="exampleFormControlInput1" class="form-label">
                            <img src="/img/en.png" width="15px" alt="">
                            Why Us Text
                        </label>
                        <textarea name="whyus_text_en" id="" cols="30" class="form-control" rows="3" required>{{ $about->whyus_text_en }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                            <img src="/img/ar.png" width="15px" alt="">
                            Why Us Text
                        </label>
                        <textarea name="whyus_text_ar" id="" cols="30" class="form-control" rows="3" required>{{ $about->whyus_text_ar }}</textarea>
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
