{{-- resources/views/admin/products/edit.blade.php --}}

<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.css')
</head>
<body class="g-sidenav-show bg-gray-100">
    @include('admin.sidebar')

    <main class="main-content position-relative border-radius-lg">
        @include('admin.navbar')

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <a href="{{ route('admin.coupons.index') }}" class="btn btn-dark">
                                <i class="bi bi-arrow-left"></i>
                                Back
                            </a>
                            <h6>Edit coupon</h6>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="card-body px-auto pt-0 pb-2">
                        <form action="{{ route('admin.coupon.update', $coupon->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="modal-body">

                                    <div class="mb-3">
                                        <label for="name" class="form-label">Coupon Name</label>
                                        <input type="text" name="name" class="form-control" id="name" value="{{ $coupon->name }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="promo_code" class="form-label">Promo Code</label>
                                        <input type="text" name="promo_code" class="form-control" id="promo_code" value="{{ $coupon->promo_code }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="discount_value" class="form-label">Discount Value</label>
                                        <input type="number" step="0.01" name="discount_value" class="form-control" id="discount_value" value="{{ $coupon->discount_value }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="discount_type" class="form-label">Discount Type</label>
                                        <select name="discount_type" class="form-control" id="discount_type" required>
                                            <option value="percentage" {{ $coupon->discount_type == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                            <option value="fixed" {{ $coupon->discount_type == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                                        </select>
                                    </div>

                                  <div class="mb-3">
                                        <label for="usage_limit" class="form-label">Usage Limit</label>
                                        <input type="number" step="0.01" name="usage_limit" class="form-control" id="usage_limit" value="{{ $coupon->usage_limit }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="min_order_amount" class="form-label">Minimum Order Amount</label>
                                        <input type="number" step="0.01" name="min_order_amount" class="form-control" id="min_order_amount" value="{{ $coupon->min_order_amount }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="expires_at" class="form-label">Expiry Date</label>
                                        <input type="datetime-local" name="expires_at" class="form-control" id="expires_at" value="{{ $coupon->expires_at ? $coupon->expires_at->format('Y-m-d\TH:i') : '' }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="active_status" class="form-label">Status</label>
                                        <select name="active_status" class="form-control" id="active_status">
                                            <option value="1" {{ $coupon->active_status == 1 ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ $coupon->active_status == 0 ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success">Save Changes <i class="bi bi-check-lg"></i></button>
                                </div>


                            </form>
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


