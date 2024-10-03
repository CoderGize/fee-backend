<a href="" class="text-success font-weight-bold text-xs" data-bs-toggle="modal"
    data-bs-target="#exampleModalEditAdmin{{ $user->id }}">
    Edit
    <i class="bi bi-pencil"></i>
</a>


<div class="modal fade" id="exampleModalEditAdmin{{ $user->id }}" tabindex="-1"
    aria-labelledby="exampleModalEditAdmin{{ $user->id }}Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalEditAdmin{{ $user->id }}Label">
                    Edit Admin
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('/admin/managers/update/' . $user->id) }}" method="POST" enctype="multipart/form-user">
                @csrf
                @method('PUT') <!-- Add this if you are using a PUT request for update -->

                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="f_name" class="form-label">First Name</label>
                        <input type="text" name="f_name" class="form-control" value="{{ old('f_name', $user->f_name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="l_name" class="form-label">Last Name</label>
                        <input type="text" name="l_name" class="form-control" value="{{ old('l_name', $user->l_name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="is_admin" class="form-label">Is Admin</label>
                        <select name="is_admin" id="is_admin" class="form-control" required>
                            <option value="1" {{ old('is_admin', $user->is_admin) == 1 ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ old('is_admin', $user->is_admin) == 0 ? 'selected' : '' }}>No</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select name="role" id="role" class="form-control" required>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>Staff</option>
                            <option value="editor" {{ old('role', $user->role) == 'editor' ? 'selected' : '' }}>Editor</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" minlength="6">
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" minlength="6">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-dark">Update
                        <i class="bi bi-check-lg"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
