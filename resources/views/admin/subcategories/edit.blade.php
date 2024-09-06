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
                    Edit Subcategory
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.subcategories.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                            Image
                        </label>
                        <input type="file" name="image" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">
                            Category
                        </label>
                        <select name="category_id" class="form-control" id="category_id" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $data->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">
                            <img src="/img/en.png" width="15px" alt="">
                            Name
                        </label>
                        <input type="text" name="name" class="form-control" value="{{ $data->name }}" required>
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
                        <input type="text" name="description" class="form-control" value="{{ $data->description }}"
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
