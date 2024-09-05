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
                    Edit Designer Story #{{$data->id}}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('/admin/web/update_designer_story/' . $data->id) }}" method="POST" enctype="multipart/form-data">
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
                            Stars
                        </label>
                        <select class="form-select" aria-label="Default select" name="star" required>
                            <option {{$data->star == 1 ? 'selected' : ''}} value="1">&#9733;</option>
                            <option {{$data->star == 1.5 ? 'selected' : ''}} value="1.5">&#9733;&#9734;</option>
                            <option {{$data->star == 2 ? 'selected' : ''}} value="2">&#9733;&#9733;</option>
                            <option {{$data->star == 2.5 ? 'selected' : ''}} value="2.5">&#9733;&#9733;&#9734;</option>
                            <option {{$data->star == 3 ? 'selected' : ''}} value="3">&#9733;&#9733;&#9733;</option>
                            <option {{$data->star == 3.5 ? 'selected' : ''}} value="3.5">&#9733;&#9733;&#9733;&#9734;</option>
                            <option {{$data->star == 4 ? 'selected' : ''}} value="4">&#9733;&#9733;&#9733;&#9733;</option>
                            <option {{$data->star == 4.5 ? 'selected' : ''}} value="4.5">&#9733;&#9733;&#9733;&#9733;&#9734;</option>
                            <option {{$data->star == 5 ? 'selected' : ''}} value="5">&#9733;&#9733;&#9733;&#9733;&#9733;</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                            <img src="/img/en.png" width="15px" alt="">
                            Name
                        </label>
                        <input type="text" name="name_en" multiple class="form-control" value="{{$data->name_en}}" required>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                            <img src="/img/ar.png" width="15px" alt="">
                            Name
                        </label>
                        <input type="text" name="name_ar" multiple class="form-control" value="{{$data->name_ar}}" required>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                            <img src="/img/en.png" width="15px" alt="">
                            Text
                        </label>
                        <textarea name="message_en" class="form-control" id="" cols="30" rows="3" required>{{$data->message_en}}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                            <img src="/img/ar.png" width="15px" alt="">
                            Text
                        </label>
                        <textarea name="message_ar" class="form-control" id="" cols="30" rows="3" required>{{$data->message_ar}}</textarea>
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
