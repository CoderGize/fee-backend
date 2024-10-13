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
                            <h6>All Guest Users Payments</h6>
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

                        <div class="row mt-1 px-4">
                            <div class="col-12 d-flex justify-content-end align-items-center">
                                <form method="GET" action="{{ route('admin.payments.guest') }}" class="d-flex">
                                    <div class="form-group mb-0 me-2">
                                        <input type="text" name="search" class="form-control" placeholder="Search users..."
                                            value="{{ request()->search }}">
                                    </div>

                                    <div class="form-group mb-0 me-2">
                                        <select name="status" class="form-control">
                                            <option value="">Select Status</option>
                                            <option value="pending" {{ request()->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="paid" {{ request()->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                            <option value="failed" {{ request()->status == 'failed' ? 'selected' : '' }}>Failed</option>
                                            <option value="expired" {{ request()->status == 'expired' ? 'selected' : '' }}>Expired</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-0 me-2">
                                        <select name="payment_method" class="form-control">
                                            <option value="">Select Payment Method</option>
                                            <option value="credit_card" {{ request()->payment_method == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                                            <option value="cash" {{ request()->payment_method == 'on_cash' ? 'selected' : '' }}>Cash</option>
                                        </select>
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
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Payment ID</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Guest Name</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Guest Email</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Guest Phone</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Order ID</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Amount</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Payment Method</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($payments as $payment)
                                            <tr>
                                                <td class="text-sm">{{ $payment->id }}</td>
                                                <td class="text-sm">{{ $payment->guest_name .' '. $payment->guest_l_name ?? 'N/A' }}</td>
                                                <td class="text-sm">{{ $payment->guest_email ?? 'N/A' }}</td>
                                                <td class="text-sm">{{ $payment->guest_phone ?? 'N/A' }}</td>
                                                <td class="text-sm">{{ $payment->order_id }}</td>
                                                <td class="text-sm">{{ $payment->amount }}</td>
                                                <td class="text-sm">
                                                    <form action="{{ url('admin/payments/update-status', $payment->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <select name="status" class="form-select" onchange="this.form.submit()">
                                                            <option value="pending" {{ $payment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                            <option value="paid" {{ $payment->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                                            <option value="delivered" {{ $payment->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                            <option value="failed" {{ $payment->status == 'failed' ? 'selected' : '' }}>Failed</option>
                                                            <option value="expired" {{ $payment->status == 'expired' ? 'selected' : '' }}>Expired</option>
                                                        </select>
                                                    </form>
                                                </td>
                                                <td class="text-sm">{{ ucfirst($payment->payment_method) }}</td>
                                                <td class="text-sm">

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $payments->links('admin.pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('admin.footer')
        </div>
    </main>

    @include('admin.script')

</body>

</html>
