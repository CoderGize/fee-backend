<button type="button" class="btn btn-dark mt-4" data-bs-toggle="modal" data-bs-target="#exampleModal">
    <i class="me-2 fs-6 bi bi-plus-lg"></i>
    Add a Coupon
</button>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Add New Coupon
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('/admin/coupons/store') }}" method="POST" enctype="multipart/form-data" >
                        @csrf
                        <div class="modal-body">

                        <div class="mb-3">
                            <label for="name" class="form-label">Coupon Name</label>
                            <input type="text" name="name" class="form-control" id="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="promo_code" class="form-label">Promo Code</label>
                            <input type="text" name="promo_code" class="form-control" id="promo_code" required>
                        </div>

                        <div class="mb-3">
                            <label for="discount_value" class="form-label">Discount Value</label>
                            <input type="number" step="0.01" name="discount_value" class="form-control" id="discount_value" required>
                        </div>

                        <div class="mb-3">
                            <label for="usage_limit" class="form-label">Usage Limit</label>
                            <input type="number" step="0.01" name="usage_limit" class="form-control" id="usage_limit" required>
                        </div>

                        <div class="mb-3">
                            <label for="discount_type" class="form-label">Discount Type</label>
                            <select name="discount_type" class="form-control" id="discount_type" required>
                                <option value="percentage">Percentage</option>
                                <option value="fixed">Fixed Amount</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="min_order_amount" class="form-label">Minimum Order Amount</label>
                            <input type="number" step="0.01" name="min_order_amount" class="form-control" id="min_order_amount">
                        </div>

                        <div class="mb-3">
                            <label for="expires_at" class="form-label">Expiry Date</label>
                            <input type="datetime-local" name="expires_at" class="form-control" id="expires_at">
                        </div>

                        <div class="mb-3">
                            <label for="active_status" class="form-label">Status</label>
                            <select name="active_status" class="form-control" id="active_status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
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
