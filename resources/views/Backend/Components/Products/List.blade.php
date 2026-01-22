<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-md-12 text-right">
                    <a class="btn btn-md btn-outline-danger" href="{{ route('productAllBarcodePrint') }}">Print Barcode</a>
                    <a class="btn btn-md btn-danger" href="{{ route('Product.Create') }}">Add New</a>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                Products
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-2">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>SKU</th>
                                        <th>Category</th>
                                        <th>Stock</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tableList"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    // Auto-load category list when page is ready
    document.addEventListener('DOMContentLoaded', function() {
        getData();
    });
    // Fetch and render categories
    async function getData() {
        try {
            showLoader();
            let res = await axios.get("/backendData/product-list");
            hideLoader();

            let tableList = $("#tableList");
            tableList.empty(); // clear old data

            // Build table rows dynamically
            res.data['data'].forEach(function(item, index) {
                let statusBadge = item['status'] === 'Active'
                    ? '<div class="badge badge-success badge-shadow">Active</div>'
                    : '<div class="badge badge-danger badge-shadow">Inactive</div>';
                let imagePath = item['image'] === null
                    ? '/assets/images/default.jpg'
                    : `/assets/uploads/products/${item['image']}`;
                let quantityClass = item['quantity'] <= item['quantity_alert'] ? 'text-danger font-weight-bold' : '';

                let row = `
                <tr>
                    <td>${index + 1}</td>
                    <td>
                        <img src="${imagePath}" alt="Category Image" style="width: 50px; height: 50px;">
                    </td>
                    <td>${item['name']}</td>
                    <td>${item['barcode']}</td>
                    <td>
                        ${item['category']['name']}
                    </td>
                    <td class="${quantityClass}">${item['quantity']}</td>
                    <td>${item['selling_price']}</td>
                    <td>${statusBadge}</td>
                    <td>
                        <div class="dropdown d-inline">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Actions
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item has-icon" href="print-single-product-barcode/${item['slug']}">
                                    <i class="fas fa-print text-danger"></i> Print Barcode
                                </a>
                                <a class="dropdown-item has-icon" href="/products/view/${item['slug']}">
                                    <i class="fas fa-eye text-success"></i> View
                                </a>
                                <a class="dropdown-item has-icon" href="/products/update/${item['slug']}">
                                    <i class="far fa-edit text-warning"></i> Update
                                </a>
                                <button class="dropdown-item has-icon deleteBtn" data-bs-toggle="modal" data-id="${item['id']}">
                                    <i class="fas fa-trash text-danger"></i> Delete
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
            `;
                tableList.append(row);
            });

            $(document).off('click', '.deleteBtn').on('click', '.deleteBtn', async function () {
                let id = $(this).data('id');
                await itemDelete(id);
            });

            // Initialize DataTable (destroy old one first if exists)
            if ( $.fn.DataTable.isDataTable('#table-2') ) {
                $('#table-2').DataTable().destroy();
            }
            $('#table-2').DataTable({
                columnDefs: [
                    { sortable: false, targets: [0, 2, 3] } // Disable sorting on specific columns
                ],
                order: [[1, "asc"]], // Default sorting on 2nd column (image/name)
                pageLength: 10 // Show 10 entries per page
            });

        } catch (e) {
            hideLoader();
            errorToast('Something Went Wrong!')
        }
    }

    // Delete category after confirmation
    async function itemDelete(id) {
        try {
            const willDelete = await swal({
                title: 'Are you sure?',
                text: 'Once deleted, you will not be able to recover this product!',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            });

            if (willDelete) {
                showLoader();
                var res = await axios.post("/backendData/product-delete", { id: id });
                if (res.data['status'] === 'success') {
                    errorToast('Product Deleted Successfully!');
                    $('#table-2').DataTable().destroy(); // Clear old datatable
                    await getData(); // Reload table
                } else {
                    hideLoader();
                    errorToast(res.data['message']);
                }
            } else {
                swal('Your Product is safe!');
            }
        } catch (error) {
            hideLoader();
            errorToast('Something Went Wrong!');
        }
    }
</script>
