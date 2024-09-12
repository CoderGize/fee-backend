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
                            <h6>All Coupons</h6>

                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="d-flex justify-content-center">

                                    @include('admin.coupons.create')

                                </div>
                            </div>
                        </div>

                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center text-center mb-0">
                                <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Coupon Name</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Promo Code</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Discount</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Min Order Amount</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Usage Limit</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Count</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Expiry Date</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created At</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($coupons as $coupon)
                                            <tr>
                                                <td class="text-sm">{{ $coupon->name }}</td>
                                                <td class="text-sm">{{ $coupon->promo_code }}</td>
                                                <td class="text-sm">{{ $coupon->getFormattedDiscountAttribute() }}</td>
                                                <td class="text-sm">${{ number_format($coupon->min_order_amount, 2) }}</td>
                                                <td class="text-sm">{{ $coupon->usage_limit }}</td>
                                                <td class="text-sm">{{ $coupon->count }}</td>
                                                <td class="text-sm">{{ $coupon->active_status ? "YES": "NO"}}</td>
                                                <td class="text-sm">{{ $coupon->getFormattedExpiresAtAttribute() ?? 'No Expiry' }}</td>
                                                <td class="text-sm">{{ $coupon->created_at->format('Y-m-d') }}</td>

                                                <td class="text-sm">
                                                    <a href="{{ route('admin.coupon.edit', $coupon->id) }}" class="text-success font-weight-bold text-xs" data-toggle="tooltip" title="Edit Coupon">
                                                        Edit <i class="bi bi-pencil"></i>
                                                    </a>
                                                </td>

                                                <td class="text-sm">
                                                    <a href="{{ route('admin.coupon.delete', $coupon->id) }}" class="text-danger font-weight-bold text-xs" data-toggle="tooltip" title="Delete Coupon" onclick="return confirm('Are you sure you want to delete this Coupon?')">
                                                        Delete <i class="bi bi-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center text-danger font-weight-bold">No Coupons Found!</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                {{ $coupons->links('admin.pagination') }}
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
