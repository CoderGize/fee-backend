<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.css')
</head>

<body class="g-sidenav-show bg-gray-100">

    @include('admin.sidebar')
    <main class="main-content position-relative border-radius-lg ">
        <!-- Navbar -->
        @include('admin.navbar')
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>All Designers</h6>
                            {{-- <a href="{{ route('admin.designer.create') }}" class="btn btn-primary btn-sm float-end">Add Designer</a> --}}
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <script>
                                setTimeout(function() {
                                    $('.alert-success').fadeOut('slow');
                                }, 5000);
                            </script>
                        @endif

                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="d-flex justify-content-center">

                                    @include('admin.designer.create')

                                </div>
                            </div>
                        </div>
                        <div class="row mt-1 px-4">
                            <div class="col-12 d-flex justify-content-end align-items-center">
                                <form method="GET" action="{{ route('admin.designer.index') }}" class="d-flex">
                                    <div class="form-group mb-0 me-2">
                                        <input type="text" name="search" class="form-control" placeholder="Search designers..."
                                            value="{{ request()->search }}">
                                    </div>

                                    <div class="form-group mb-0 me-2">
                                        <select name="per_page" class="form-control">
                                            <option value="10" {{ request()->per_page == 10 ? 'selected' : '' }}>10 per page</option>
                                            <option value="25" {{ request()->per_page == 25 ? 'selected' : '' }}>25 per page</option>
                                            <option value="50" {{ request()->per_page == 50 ? 'selected' : '' }}>50 per page</option>
                                        </select>
                                    </div>

                                    <div>
                                        <button type="submit" class="btn btn-primary">Apply</button>
                                    </div>
                                </form>
                            </div>
                        </div>


                        <div class="card-body px-4 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center text-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Profile Image</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">First Name</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Last Name</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">phone</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Username</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created At</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody  >
                                        @forelse ($designers as $designer)
                                            <tr>
                                                <td class="text-sm">
                                                    @if ($designer->image)
                                                        <img src="{{ $designer->image }}" class="rounded-circle" alt="Profile Image" width="50">
                                                    @else
                                                        <p class="text-danger">
                                                            No Image
                                                        </p>
                                                    @endif
                                                </td>

                                                <td class="text-sm">{{ $designer->f_name }}</td>

                                                <td class="text-sm">{{ $designer->l_name }}</td>
                                                <td class="text-sm">+{{ $designer->phone_number }}</td>

                                                <td class="text-sm">{{ $designer->email }}</td>

                                                <td class="text-sm">{{ $designer->username }}</td>

                                                <td class="text-sm">{{ $designer->created_at->format('Y-m-d') }}</td>

                                                {{-- <td class="text-sm">
                                                    <a href="{{ url('admin/designers/edit', $designer->id) }}" class="text-success font-weight-bold text-xs text-center" data-toggle="tooltip" title="Edit Designer">
                                                        Edit <i class="bi bi-pencil"></i>
                                                    </a>
                                                </td> --}}
                                                <input type="hidden" value="{{env('APP_LINK') . '/designer-registration/' . Crypt::encryptString($designer->id) }}" id="linkToCopy">

                                                <td class="text-sm">
                                                    <a href="#" class="text-primary font-weight-bold text-xs text-center" data-toggle="tooltip" title="Copy Designer Info" onclick="confirmCopy()">
                                                        Copy Link <i class="bi bi-clipboard"></i>
                                                    </a>
                                                </td>

                                                <td class="text-sm ">
                                                    <a href="{{ url('admin/designers/delete', $designer->id) }}" class="text-danger font-weight-bold text-xs text-center m-auto" data-toggle="tooltip" title="Delete Designer" onclick="return confirm('Are you sure you want to delete this Designer?')">
                                                        Delete <i class="bi bi-trash"></i>
                                                    </a>
                                                </td>


                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-danger font-weight-bold">No Designers Found!</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                {{ $designers->links('admin.pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('admin.footer')
        </div>
    </main>

    @include('admin.script')

    <script>
    function copyDesignerInfo(username, email, plainPassword) {

        var designerInfo = `Username: ${username}\nEmail: ${email}\nPassword: ${plainPassword}`;


        var tempInput = document.createElement("textarea");
        tempInput.style.position = "absolute";
        tempInput.style.left = "-1000px";
        tempInput.value = designerInfo;
        document.body.appendChild(tempInput);


        tempInput.select();
        tempInput.setSelectionRange(0, 99999);


        document.execCommand("copy");


        document.body.removeChild(tempInput);


        alert("Copied to clipboard:\n" + designerInfo);


    }

    function confirmCopy() {
        // Show confirmation dialog
        var userConfirmed = confirm("Are you sure you want to copy this link?");

        // If the user clicks "OK", proceed with copying the link
        if (userConfirmed) {
            copyLink();
        }
    }

    function copyLink() {
        // Get the link value
        var link = document.getElementById("linkToCopy").value;

        // Use the modern clipboard API to copy text
        navigator.clipboard.writeText(link).then(function() {
            // Show the success message
            document.getElementById("copyMessage").style.display = "block";
        }).catch(function(error) {
            console.error('Could not copy text: ', error);
        });
    }

</script>


</body>

</html>
