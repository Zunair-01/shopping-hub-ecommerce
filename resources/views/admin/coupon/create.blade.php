@extends('admin.layouts.master')
@section('title')
    {{ isset($title) ? $title : '' }}
@stop

@section('content')
    <div class="nk-block nk-block-lg">
        <div class="nk-block-head">
            <div class="nk-block-head-content">
                <h4 class="title nk-block-title">Coupon Form</h4>
                <div class="nk-block-des">
                    <p>Validating your form, just add the class <code class="code-class">.form-validate</code> to any <code
                            class="code-tag">&lt;form&gt;</code>, then it validates the form and shows error messages.</p>
                </div>
            </div>
        </div>
        <div class="card card-bordered">
            <div class="card-inner">
                <form id="couponForm" class="form-validate" method="POST" action="{{ route('coupon.store') }}">
                    @csrf
                    <div class="row g-gs">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="code">Code</label>
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-mail"></em>
                                    </div>
                                    <input type="text" class="form-control" id="code" name="code" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="discount_amount">Discount Amount</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="discount_amount" name="discount_amount"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-lg btn-primary">Save Information</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- .nk-block -->
@stop

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#couponForm").on("submit", function(e) {
                e.preventDefault();

                var form = $(this);
                var actionUrl = form.attr("action");
                console.log("Submitting form to: " + actionUrl); // Debugging log
                $.ajax({
                    url: actionUrl,
                    method: "POST",
                    data: form.serialize(),
                    success: function(response) {
                        if (response.success) {
                            console.log("Coupon created successfully:", response);
                            $("#couponForm")[0].reset();
                            alert("Coupon created successfully!"); // Optional success message
                        } else {
                            alert("Failed to save Coupon.");
                        }
                    },
                    error: function(xhr) {
                        // Check if the response has errors
                        var errorMessage = "An unexpected error occurred.";
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            const errors = xhr.responseJSON.errors;
                            errorMessage = "";
                            $.each(errors, function(key, value) {
                                errorMessage += value +
                                "\n"; // Append each error message
                            });
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON
                            .message; // Use general error message
                        }
                        alert(errorMessage); // Show the error message
                    },
                });
            });
        });
    </script>
@stop
