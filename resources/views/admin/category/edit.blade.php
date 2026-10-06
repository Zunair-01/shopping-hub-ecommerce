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
                <form id="categoryEditForm" class="form-validate" method="POST"
                    action="{{ route('category.update', $category->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row g-gs">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="category_name">Category Name</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="category_name" name="category_name"
                                        value="{{ $category->category_name }}" required>
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
                                    <input type="text" class="form-control" id="category_type" name="category_type"
                                        value="{{ $category->category_type }}" required>
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
        var categoryIndexUrl = "{{ route('category.index') }}";
    </script>
    <script src="{{ asset('js/admin/category.js') }}"></script>
@stop
