@extends('admin.layouts.master')
@section('title')
    {{ isset($title) ? $title : '' }}
@stop
@section('content')
    <div class="nk-block nk-block-lg">
        <div class="nk-block-head">
            <div class="nk-block-head-content">
                <h4 class="title nk-block-title">Edit Category</h4>
                <div class="nk-block-des">
                    <p>Edit your category details below.</p>
                </div>
            </div>
        </div>
        <div class="card card-bordered">
            <div class="card-inner">
                <form id="discountEditForm" class="form-validate" method="POST"
                    action="{{ route('discount.update', $discount->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row g-gs">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="discount">Discount Name</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="discount" name="discount"
                                        value="{{ $discount->discount }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="tax">Tax</label>
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-mail"></em>
                                    </div>
                                    <input type="text" class="form-control" id="tax" name="tax"
                                        value="{{ $discount->tax }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="shipping_charges">Shipping Charges</label>
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-mail"></em>
                                    </div>
                                    <input type="text" class="form-control" id="shipping_charges" name="shipping_charges"
                                        value="{{ $discount->shipping_charges }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-lg btn-primary">Update Category</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- .nk-block -->
@stop
@section('js')
    <script>
        $(document).ready(function() {
            $("#discountEditForm").on("submit", function(e) {
                e.preventDefault();

                var form = $(this);
                var actionUrl = form.attr("action");

                $.ajax({
                    url: actionUrl,
                    method: "PUT",
                    data: form.serialize(),
                    success: function(response) {
                        if (response.success) {
                            console.log("discount updated successfully:", response);
                            window.location.href = "{{ route('discount.index') }}";
                        } else {
                            alert("Failed to update discount.");
                        }
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = "";
                        $.each(errors, function(key, value) {
                            errorMessage += value + "\n";
                        });
                        alert(errorMessage);
                    },
                });
            });
        });
    </script>
@stop
