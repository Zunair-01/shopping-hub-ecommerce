@extends('user.layouts.master')

@section('content')
    <div class="container wide-xl">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-content-wrap">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between g-3">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Product Details</h3>
                                <div class="nk-block-des text-soft">
                                    <p>An example page for product details</p>
                                </div>
                            </div>
                            <div class="nk-block-head-content">
                                <a href="javascript:void(0)" id="backBtn"
                                    class="btn btn-outline-light bg-white d-none d-sm-inline-flex">
                                    <em class="icon ni ni-arrow-left"></em><span>Back</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="nk-block" id="productDetail">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <div class="row pb-5">
                                    <div class="col-lg-6">
                                        <div class="product-gallery" id="productGallery"></div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div id="productInfo"></div>
                                    </div>
                                </div>
                                <hr class="hr border-light">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            function fetchProductDetails() {
                const productId = "{{ $product->id }}";
                const userId = "{{ auth()->user()->id }}"; // Assuming the user is authenticated

                $.ajax({
                    url: '{{ route('product.show', $product->id) }}',
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        let productImages = Array.isArray(data.product.images) && data.product.images
                            .length > 0 ?
                            data.product.images : [
                                "path/to/default/image.jpg"
                            ];

                        productImages = productImages.map(image =>
                            image.replace(/[\[\]"]/g, "").replace(/\\/g, "/").replace(/\/+/g, "/")
                            .trim()
                        );

                        let galleryHtml = `
                            <div class="slider-init" id="sliderFor" data-slick='{"arrows": false, "fade": true, "asNavFor":"#sliderNav"}'>
                                ${productImages.map(image => `
                                                    <div class="slider-item rounded">
                                                        <img src="{{ asset('storage/${image}') }}" class="rounded w-100" alt="Product Image">
                                                    </div>
                                                `).join('')}
                            </div>
                            <div class="slider-init slider-nav" id="sliderNav" data-slick='{"arrows": false, "asNavFor":"#sliderFor", "centerMode": true, "focusOnSelect": true}' >
                                ${productImages.map(image => `
                                                    <div class="slider-item">
                                                        <div class="thumb">
                                                            <img src="{{ asset('storage/${image}') }}" class="rounded" alt="Product Thumbnail">
                                                        </div>
                                                    </div>
                                                `).join('')}
                            </div>
                        `;

                        $('#productGallery').html(galleryHtml);

                        let productInfoHtml = `
                            <h4 class="product-price text-primary">${data.product.sale_price}
                                <small class="text-muted fs-14px">${data.product.regular_price || ''}</small>
                            </h4>
                            <h2 class="product-title">${data.product.title || 'No Title'}</h2>
                            <div class="product-excerpt text-soft">
                                <p class="lead">${data.product.description || 'No description available.'}</p>
                            </div>

                            <div class="product-meta">
                                <h6 class="title">Size</h6>
                                <ul class="custom-control-group">
                                    <li>
                                        <div class="custom-control custom-radio custom-control-pro no-control">
                                            <input type="radio" class="custom-control-input" name="sizeCheck" id="sizeCheck1" value="XS" checked>
                                            <label class="custom-control-label" for="sizeCheck1">XS</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-radio custom-control-pro no-control">
                                            <input type="radio" class="custom-control-input" name="sizeCheck" id="sizeCheck2" value="SM">
                                            <label class="custom-control-label" for="sizeCheck2">SM</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-radio custom-control-pro no-control">
                                            <input type="radio" class="custom-control-input" name="sizeCheck" id="sizeCheck3" value="L">
                                            <label class="custom-control-label" for="sizeCheck3">L</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-radio custom-control-pro no-control">
                                            <input type="radio" class="custom-control-input" name="sizeCheck" id="sizeCheck4" value="XL">
                                            <label class="custom-control-label" for="sizeCheck4">XL</label>
                                        </div>
                                    </li>
                                </ul>
                            </div><!-- .product-meta -->

                            <div class="product-meta">
                                <ul class="d-flex flex-wrap ailgn-center g-2 pt-1">
                                    <li class="w-140px">
                                        <div class="form-control-wrap number-spinner-wrap">
                                            <button class="btn btn-icon btn-outline-light number-spinner-btn number-minus" data-number="minus"><em class="icon ni ni-minus"></em></button>
                                            <input type="number" class="form-control number-spinner" id="productQuantity" value="1">
                                            <button class="btn btn-icon btn-outline-light number-spinner-btn number-plus" data-number="plus"><em class="icon ni ni-plus"></em></button>
                                        </div>
                                    </li>
                                    <li>
                                        <button class="btn btn-primary" id="addToCartBtn">Add to Cart</button>
                                    </li>
                                    <li class="ml-n1">
                                        <button class="btn btn-icon btn-trigger text-primary" id="addToWishlistBtn">
                                             <em class="icon ni ni-heart"></em>
                                        </button>
                                    </li>
                                </ul>
                            </div><!-- .product-meta -->
                        `;

                        $('#productInfo').html(productInfoHtml);

                        // Initialize the slider after content is added
                        initializeSliders();

                        // Add event listener for "Add to Cart" button
                        $('#addToCartBtn').on('click', function() {
                            let size = $('input[name="sizeCheck"]:checked').val();
                            let quantity = $('#productQuantity').val();
                            addToCart(productId, userId, size, quantity);
                        });
                    },
                    error: function(error) {
                        console.log("Error fetching product details: ", error);
                    }
                });
            }

            function addToCart(productId, userId, size, quantity) {
                $.ajax({
                    url: '{{ route('cart.add') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: productId,
                        user_id: userId,
                        size: size,
                        quantity: quantity
                    },
                    success: function(response) {
                        alert(response.message);
                        // Optionally, update the cart UI or show a success message
                    },
                    error: function(error) {
                        console.log("Error adding to cart: ", error);
                    }
                });
            }

            // Add event listener for "Add to Wishlist" button
    $('#addToWishlistBtn').on('click', function() {
        const productId = "{{ $product->id }}"; // Get the product ID
        const userId = "{{ auth()->user()->id }}"; // Get the user ID
        addToWishlist(productId, userId);
    });

    function addToWishlist(productId, userId) {
        $.ajax({
            url: '{{ route('wishlist.add') }}', // Change to your route for adding to wishlist
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                product_id: productId,
                user_id: userId
            },
            success: function(response) {
                alert(response.message); // Display success message

                // Change the heart icon color to red
                $('#addToWishlistBtn em.icon').removeClass('ni-heart').addClass('ni-heart-fill');
                $('#addToWishlistBtn').addClass('text-danger'); // Optionally add a class for color

                // Optionally, update the UI or show a success notification
            },
            error: function(error) {
                console.log("Error adding to wishlist: ", error);
                alert('Failed to add to wishlist.'); // Display error message
            }
        });
    }

            function initializeSliders() {
                $('#sliderFor').slick({
                    arrows: false,
                    fade: true,
                    asNavFor: '#sliderNav',
                });
                $('#sliderNav').slick({
                    arrows: false,
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    asNavFor: '#sliderFor',
                    centerMode: true,
                    focusOnSelect: true,
                });
            }

            // Event delegation for quantity adjustment buttons
            $(document).on('click', '.number-spinner-btn', function() {
                const $input = $(this).siblings('.number-spinner');
                let currentVal = parseInt($input.val());

                console.log(`Current value before change: ${currentVal}`);

                if ($(this).data('number') === 'plus') {
                    currentVal += 1;
                } else {
                    // Prevent going below 1
                    if (currentVal > 1) {
                        currentVal -= 1;
                    }
                }

                $input.val(currentVal);
                console.log(`New value after change: ${currentVal}`);
            });

            fetchProductDetails();
        });
    </script>
@stop
