<a href="" class="text-success font-weight-bold text-xs" data-bs-toggle="modal"
    data-bs-target="#exampleModaledit{{ $data->id }}">
    Edit
    <i class=" bi bi-pencil"></i>
</a>

<div class="modal fade" id="exampleModaledit{{ $data->id }}" tabindex="-1"
    aria-labelledby="exampleModaledit{{ $data->id }}Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModaledit{{ $data->id }}Label">
                    Edit Collection
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.collections.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                            Image
                        </label>
                        <input type="file" name="img" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                            <img src="/img/en.png" width="15px" alt="">
                            Name
                        </label>
                        <input type="text" name="name_en" class="form-control" value="{{ $data->name_en }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                            <img src="/img/ar.png" width="15px" alt="">
                            Name
                        </label>
                        <input type="text" name="name_ar" class="form-control" value="{{ $data->name_ar }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                            <img src="/img/en.png" width="15px" alt="">
                            Description
                        </label>
                        <input type="text" name="description_en" class="form-control" value="{{ $data->description_en }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                            <img src="/img/ar.png" width="15px" alt="">
                            Description
                        </label>
                        <input type="text" name="description_ar" class="form-control" value="{{ $data->description_ar }}"
                            required>
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
