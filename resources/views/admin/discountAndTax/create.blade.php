@extends('admin.layouts.master')
@section('title')
    {{ isset($title) ? $title : '' }}
@stop
@section('content')
    <div class="nk-block nk-block-lg">
        <div class="nk-block-head">
            <div class="nk-block-head-content">
                <h4 class="title nk-block-title">Discount Form</h4>
                <div class="nk-block-des">
                    <p>Validating your form, just add the class <code class="code-class">.form-validate</code> to any <code
                            class="code-tag">&lt;form&gt;</code>, then it validate the form show error message.</p>
                </div>
            </div>
        </div>
        <div class="card card-bordered">
            <div class="card-inner">
                <!-- Add an ID to the form for jQuery -->
                <form id="discountForm" class="form-validate" method="POST" action="{{ route('discount.store') }}">
                    @csrf
                    <div class="row g-gs">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="discount">Discount</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="discount" name="discount" required>
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
                                    <input type="text" class="form-control" id="tax" name="tax">
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
                                    <input type="text" class="form-control" id="shipping_charges"
                                        name="shipping_charges">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-lg btn-primary">Save Informations</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- .nk-block -->
@stop
@section('js')
<Script>
$(document).ready(function () {
    $("#discountForm").on("submit", function (e) {
        e.preventDefault();

        var form = $(this);
        var actionUrl = form.attr("action");

        $.ajax({
            url: actionUrl,
            method: "POST",
            data: form.serialize(),
            success: function (response) {
                if (response.success) {
                    console.log("Discount created successfully:", response);
                    $("#discountForm")[0].reset();
                } else {
                    alert("Failed to save discount.");
                }
            },
            error: function (xhr) {
                var errors = xhr.responseJSON.errors;
                var errorMessage = "";
                $.each(errors, function (key, value) {
                    errorMessage += value + "\n";
                });
                alert(errorMessage);
            },
        });
    });
});
</Script>
@stop
