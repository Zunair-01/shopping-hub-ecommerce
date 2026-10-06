@extends('user.layouts.master')
@section('title')
    {{ isset($title) ? $title : '' }}
@stop
@section('content')
    <div class="nk-block">
        <div class="row g-gs" id="product-list">
            <!-- Products will be loaded here via AJAX -->
        </div>
    </div><!-- .nk-block -->
@stop
@section('js')
    <script>
        $(document).ready(function() {
            // Function to fetch products
            function fetchProducts() {
                $.ajax({
                    url: "{{ route('user.dashboard') }}",
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        let productList = '';
                        // Access the products array within the response
                        if (response && Array.isArray(response.products)) {
                            response.products.forEach(function(product) {
                                let productImage = "";

                                // Check if product.images exists and is not null
                                if (product.images) {
                                    productImage = product.images
                                        .replace(/[\[\]"]/g, "")
                                        .trim();
                                    productImage = productImage.replace(/\\/g, "/");
                                    if (productImage.includes(",")) {
                                        productImage = productImage.split(",")[0];
                                    }
                                } else {
                                    productImage = "path/to/default/image.jpg";
                                }

                                productList += `
                    <div class="col-lg-4 col-sm-6">
                        <div class="card card-bordered product-card">
                            <div class="product-thumb">
                                <a href="product/${product.id}/show" class="load-product">
                                    <img class="card-img-top" src="storage/${productImage}" alt="${product.name}">
                                </a>
                                <ul class="product-badges">
                                    ${product.is_new ? '<li><span class="badge badge-success">New</span></li>' : ''}
                                </ul>
                                <ul class="product-actions">
                                    <li><a href="#"><em class="icon ni ni-cart"></em></a></li>
                                    <li><a href="#"><em class="icon ni ni-heart"></em></a></li>
                                </ul>
                            </div>
                            <div class="card-inner text-center">
                                <ul class="product-tags">
                                    <li><a href="#">${product.category.category_type}</a></li>
                                </ul>
                                <h5 class="product-title"><a href="html/product-details.html">${product.title}</a></h5>
                                <div class="product-price text-primary h5">
                                    ${product.regular_price ? `<small class="text-muted del fs-13px">$${product.sale_price}</small> $${product.regular_price}` : `$${product.sale_price}`}
                                </div>
                            </div>
                        </div>
                    </div>`;
                            });
                            $('#product-list').html(
                                productList); // Append products to the product-list container
                        } else {
                            console.error("Invalid response format:", response);
                        }
                    },
                    error: function(error) {
                        console.log('Error fetching products:', error);
                    }
                });
            }

            // Call the function to fetch products on page load
            fetchProducts();
        });
    </script>
@stop
