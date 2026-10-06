@extends('admin.layouts.master')
@section('title')
    {{ isset($title) ? $title : '' }}
@stop
@section('content')
    <div class="nk-block nk-block-lg">
        <div class="nk-block-head">
            <div class="nk-block-head-content">
                <h4 class="title nk-block-title">Category Form</h4>
                <div class="nk-block-des">
                    <p>Validating your form, just add the class <code class="code-class">.form-validate</code> to any <code
                            class="code-tag">&lt;form&gt;</code>, then it validate the form show error message.</p>
                </div>
            </div>
        </div>
        <div class="card card-bordered">
            <div class="card-inner">
                <!-- Add an ID to the form for jQuery -->
                <form id="categoryForm" class="form-validate" method="POST" action="{{ route('category.store') }}">
                    @csrf
                    <div class="row g-gs">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="category_name">Category Name</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="category_name" name="category_name"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="category_type">Category Type</label>
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-right">
                                        <em class="icon ni ni-mail"></em>
                                    </div>
                                    <input type="text" class="form-control" id="category_type" name="category_type">
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
    <script>
        var categoryIndexUrl = "{{ route('category.index') }}";
    </script>
    <script src="{{ asset('js/admin/category.js') }}"></script>
@stop
