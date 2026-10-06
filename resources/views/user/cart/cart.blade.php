@extends('user.layouts.master')

@section('title', 'Your Cart')

@section('content')
<div class="container mt-5">
    <div class="row">
        <!-- Cart Items Section -->
        <div class="col-md-8">
            <h1 class="mb-4">Your Cart</h1>
            <div id="cart-items">
                <!-- Cart items will be loaded here via AJAX -->
            </div>
        </div>

        <!-- Cart Summary Section -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Summary</h4>
                </div>
                <div class="card-body">
                    <p>Total Products: <strong id="total-products">0</strong></p>
                    <p>Total Quantity: <strong id="total-quantity">0</strong></p>
                    <p>Total Amount: <strong>$<span id="total-amount">0.00</span></strong></p>
                    <p>Discount: <strong>$<span id="discount-amount">0.00</span></strong></p>
                    <p>Tax: <strong>$<span id="tax-amount">0.00</span></strong></p>
                    <p>Shipping Charges: <strong>$<span id="shipping-charges">0.00</span></strong></p>
                    <hr>
                    <p>Final Amount: <strong>$<span id="final-amount">0.00</span></strong></p>
                    <hr>
                    <a href="#" class="btn btn-success btn-block">Proceed to Checkout</a>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    // Fetch the cart items via AJAX
    function fetchCartData() {
        $.ajax({
            url: "{{ route('cart.index') }}",
            type: 'GET',
            success: function(response) {
                let cartItemsHtml = '';
                let totalQuantity = 0;

                response.cartItems.forEach(function(item) {
                    let productImage = "";

                    // Check if product.images exists and is not null
                    if (item.product.images) {
                        productImage = item.product.images
                            .replace(/[\[\]"]/g, "")
                            .trim();
                        productImage = productImage.replace(/\\/g, "/");
                        if (productImage.includes(",")) {
                            productImage = productImage.split(",")[0];
                        }
                    } else {
                        productImage = "path/to/default/image.jpg";
                    }
                    let price = item.product.sale_price ? item.product.sale_price : item.product.regular_price;
                    cartItemsHtml += `
                        <div class="card mb-3">
                            <div class="row no-gutters">
                                <div class="col-md-4">
                                    <img src="storage/${productImage}" class="card-img" alt="${item.product.title}">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">${item.product.title}</h5>
                                        <p class="card-text">
                                            Size: ${item.size}<br>Price: $${price}<br>Quantity:
                                            <input type="number" class="form-control d-inline-block w-auto" value="${item.quantity}" min="1" onchange="updateQuantity(${item.id}, this.value)">
                                        </p>
                                        <button class="btn btn-danger" onclick="removeItem(${item.id})">Remove</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                    totalQuantity += item.quantity;
                });

                $('#cart-items').html(cartItemsHtml);
                $('#total-products').text(response.cartItems.length);
                $('#total-quantity').text(totalQuantity);
                $('#total-amount').text(response.totalAmount);

                // Display discount, tax, shipping charges, and final amount
                $('#discount-amount').text(response.discountAmount);
                $('#tax-amount').text(response.taxAmount);
                $('#shipping-charges').text(response.shippingCharges);
                $('#final-amount').text(response.finalAmount);
            },
            error: function(xhr) {
                alert('Error fetching cart data.');
            }
        });
    }

    // Update quantity using AJAX
    function updateQuantity(cartId, quantity) {
        $.ajax({
            url: "{{ url('cart/update-quantity') }}/" + cartId,
            type: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                quantity: quantity
            },
            success: function(response) {
                fetchCartData(); // Refresh the cart data
            },
            error: function(xhr) {
                alert('Error updating quantity.');
            }
        });
    }

    // Remove item from cart using AJAX
    function removeItem(cartId) {
        if (!confirm('Are you sure you want to remove this item?')) {
            return;
        }

        $.ajax({
            url: "{{ url('cart/remove') }}/" + cartId,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                fetchCartData(); // Refresh the cart data
            },
            error: function(xhr) {
                alert('Error removing item.');
            }
        });
    }

    // Load the cart data on page load
    $(document).ready(function() {
        fetchCartData();
    });
</script>
@stop
