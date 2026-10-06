// ------------------------------ Script ------------------------------
src = "https://code.jquery.com/jquery-3.6.0.min.js";

// ------------------------------ Index Script ------------------------------

$(document).ready(function () {
    fetchCategories();
});

function fetchCategories() {
    $.ajax({
        url: productIndexUrl,
        method: "GET",
        success: function (response) {
            console.log(response); // Log response to check structure
            let categoryTableBody = "";

            if (response && Array.isArray(response)) {
                response.forEach(function (product) {
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
                    categoryTableBody += `
                        <div class="nk-tb-item">
                            <div class="nk-tb-col nk-tb-col-check">
                                <div class="custom-control custom-control-sm custom-checkbox notext">
                                    <input type="checkbox" class="custom-control-input" id="pid${product.id}">
                                    <label class="custom-control-label" for="pid${product.id}"></label>
                                </div>
                            </div>
                            <div class="nk-tb-col tb-col-sm">
                                <span class="tb-product">
                                    <img src="storage/${productImage}" alt="" class="thumb">
                                    <span class="title">${product.title}</span>
                                </span>
                            </div>
                            <div class="nk-tb-col">
                                <span class="tb-sub">${product.sku}</span>
                            </div>
                            <div class="nk-tb-col">
                                <span class="tb-lead">$ ${product.sale_price}</span>
                            </div>
                            <div class="nk-tb-col">
                                <span class="tb-sub">${product.stock}</span>
                            </div>
                            <div class="nk-tb-col tb-col-md">
                                <span class="tb-sub">${product.category.category_name}, ${product.category.category_type}</span>
                            </div>
                            <div class="nk-tb-col tb-col-md">
                                <div class="asterisk tb-asterisk">
                                    <a href="#">
                                        <em class="asterisk-off icon ni ni-star"></em>
                                        <em class="asterisk-on icon ni ni-star-fill"></em>
                                    </a>
                                </div>
                            </div>
                            <div class="nk-tb-col nk-tb-col-tools">
                                <ul class="nk-tb-actions gx-1 my-n1">
                                    <li class="mr-n1">
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a href="/product/${product.id}/edit"><em class="icon ni ni-edit"></em><span>Edit Product</span></a></li>
                                                    <li><a href="#"><em class="icon ni ni-eye"></em><span>View Product</span></a></li>
                                                    <li><a href="#"><em class="icon ni ni-activity-round"></em><span>Product Orders</span></a></li>
                                                    <li><a onclick="deleteSubmission(${product.id})"><em class="icon ni ni-trash"></em><span>Remove Product</span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    `;
                });

                $(".nk-tb-list").html(categoryTableBody);
            } else {
                console.error("Invalid response format:", response);
            }
        },
        error: function (xhr) {
            console.error("Error fetching products:", xhr);
        },
    });
}

// ------------------------------ Created Script ------------------------------

$(document).ready(function () {
    $("#product-form").on("submit", function (e) {
        e.preventDefault();

        let formData = new FormData(this);
        var actionUrl = $(this).attr("action");

        let files = $("#images")[0].files;
        for (let i = 0; i < files.length; i++) {
            formData.append("images[]", files[i]);
        }

        $.ajax({
            url: actionUrl,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                alert("Product added successfully!");
                $("#product-form")[0].reset();
                $("#images").val("");
            },
            error: function (xhr) {
                console.log(xhr.responseJSON);
                alert("Error adding product. Please try again.");
            },
        });
    });
});

// ------------------------------ Edit Script ------------------------------

$(document).ready(function () {
    $("#edit-product-form").on("submit", function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: $(this).attr("action"),
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                alert("Product updated successfully!");
                window.location.href = productIndexUrl;
            },
            error: function (xhr) {
                var errors = xhr.responseJSON.errors;
                if (errors) {
                    $.each(errors, function (key, value) {
                        alert(value[0]);
                    });
                } else {
                    alert("An error occurred. Please try again.");
                }
            },
        });
    });
});

// ------------------------------ Delete Script ------------------------------

function deleteSubmission(id) {
    if (confirm("Are you sure you want to delete this submission?")) {
        $.ajax({
            url: `/product/${id}/delete`,
            method: "DELETE",
            data: {
                _token: "{{ csrf_token() }}",
            },
            success: function (response) {
                alert(response.success);
                $(`#submission-${id}`).remove();
                fetchCategories();
            },
            error: function (xhr) {
                console.error("Error deleting submission:", xhr.responseText);
            },
        });
    }
}
