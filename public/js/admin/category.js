// ------------------------------ Script ------------------------------
src = "https://code.jquery.com/jquery-3.6.0.min.js";

// ------------------------------ Index Script ------------------------------

$(document).ready(function () {
    fetchCategories();
});

function fetchCategories() {
    $.ajax({
        url: categoryIndexUrl,
        method: "GET",
        success: function (response) {
            let categoryTableBody = "";
            response.forEach(function (category, index) {
                categoryTableBody += `
                    <tr class="tb-tnx-item">
                        <td class="tb-tnx-id">
                            <a href="#"><span>${category.id}</span></a>
                        </td>
                        <td class="tb-tnx-info">
                            <div class="tb-tnx-desc">
                                <span class="title">${
                                    category.category_name
                                }</span>
                            </div>
                            <div class="tb-tnx-date">
                                <span class="date">${new Date(
                                    category.created_at
                                ).toLocaleDateString()}</span>
                            </div>
                        </td>
                        <td class="tb-tnx-amount is-alt">
                            <div class="tb-tnx-total">
                                <span class="amount">${
                                    category.category_type
                                }</span>
                            </div>
                        </td>
                        <td class="tb-tnx-action">
                            <div class="dropdown">
                                <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-xs">
                                    <ul class="link-list-plain">
                                        <li><a href="#">View</a></li>
                                        <li><a href="/category/${
                                            category.id
                                        }/edit">Edit</a></li>
                                        <li><a onclick="deleteSubmission(${
                                            category.id
                                        })">Remove</a></li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                `;
            });

            $("tbody").html(categoryTableBody);
        },
        error: function (error) {
            console.error("Error fetching categories:", error);
        },
    });
}

// ------------------------------ create Script ------------------------------

$(document).ready(function () {
    $("#categoryForm").on("submit", function (e) {
        e.preventDefault();

        var form = $(this);
        var actionUrl = form.attr("action");

        $.ajax({
            url: actionUrl,
            method: "POST",
            data: form.serialize(),
            success: function (response) {
                if (response.success) {
                    console.log("Category created successfully:", response);
                    $("#categoryForm")[0].reset();
                } else {
                    alert("Failed to save category.");
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

// ------------------------------ Edit Script ------------------------------

$(document).ready(function () {
    $("#categoryEditForm").on("submit", function (e) {
        e.preventDefault();

        var form = $(this);
        var actionUrl = form.attr("action");

        $.ajax({
            url: actionUrl,
            method: "PUT",
            data: form.serialize(),
            success: function (response) {
                if (response.success) {
                    console.log("Category updated successfully:", response);
                    window.location.href = categoryIndexUrl;
                } else {
                    alert("Failed to update category.");
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

// ------------------------------ Delete Script ------------------------------

function deleteSubmission(categoryId) {
    $.ajax({
        url: `/category/${categoryId}/delete`,
        type: "DELETE",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            console.log("Category deleted successfully:", response);
            fetchCategories();
        },
        error: function (xhr, status, error) {
            console.error("Error deleting category:", xhr.responseText);
        },
    });
}
