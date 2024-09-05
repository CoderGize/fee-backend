<button type="button" class="btn btn-dark mt-4" data-bs-toggle="modal" data-bs-target="#exampleModaladd">
    <i class="me-2 fs-6 bi bi-plus-lg"></i>
    Add Customer Testimonial
</button>

<div class="modal fade" id="exampleModaladd" tabindex="-1" aria-labelledby="exampleModaladdLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModaladdLabel">Add Customer Testimonial
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('/admin/web/add_testimonial') }}" method="POST" enctype="multipart/form-data">
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
                            Stars
                        </label>
                        <select class="form-select" aria-label="Default select" name="star" required>
                            <option selected value="1">&#9733;</option>
                            <option value="1.5">&#9733;&#9734;</option>
                            <option value="2">&#9733;&#9733;</option>
                            <option value="2.5">&#9733;&#9733;&#9734;</option>
                            <option value="3">&#9733;&#9733;&#9733;</option>
                            <option value="3.5">&#9733;&#9733;&#9733;&#9734;</option>
                            <option value="4">&#9733;&#9733;&#9733;&#9733;</option>
                            <option value="4.5">&#9733;&#9733;&#9733;&#9733;&#9734;</option>
                            <option value="5">&#9733;&#9733;&#9733;&#9733;&#9733;</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                            <img src="/img/en.png" width="15px" alt="">
                            Name
                        </label>
                        <input type="text" name="name_en" multiple class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                            <img src="/img/ar.png" width="15px" alt="">
                            Name
                        </label>
                        <input type="text" name="name_ar" multiple class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                            <img src="/img/en.png" width="15px" alt="">
                            Text
                        </label>
                        <textarea name="message_en" class="form-control" id="" cols="30" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                            <img src="/img/ar.png" width="15px" alt="">
                            Text
                        </label>
                        <textarea name="message_ar" class="form-control" id="" cols="30" rows="3" required></textarea>
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
