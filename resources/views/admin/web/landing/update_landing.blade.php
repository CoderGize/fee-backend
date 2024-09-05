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
                    Edit landing Item #{{$data->id}}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('/admin/web/update_landing/' . $data->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <div class="modal-body">

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                            Image
                            <span class="text-danger fw-light fs-xs">
                                *1440x1025*
                            </span>
                        </label>
                        <input type="file" name="img" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                            <img src="/img/en.png" width="15px" alt="">
                            Title
                        </label>
                        <input type="text" name="title_en" multiple class="form-control" value="{{ $data->title_en }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                            <img src="/img/en.png" width="15px" alt="">
                            Subitle
                        </label>
                        <input type="text" name="subtitle_en" multiple class="form-control" value="{{ $data->subtitle_en }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                            <img src="/img/ar.png" width="15px" alt="">
                            Title
                        </label>
                        <input type="text" name="title_ar" multiple class="form-control" value="{{ $data->title_ar }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                            <img src="/img/ar.png" width="15px" alt="">
                            Subitle
                        </label>
                        <input type="text" name="subtitle_ar" multiple class="form-control" value="{{ $data->subtitle_ar }}"
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
