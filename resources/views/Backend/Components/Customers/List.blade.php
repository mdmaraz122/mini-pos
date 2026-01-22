<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-md-12 text-right">
                    <button class="btn btn-md btn-danger" type="button" data-toggle="modal" data-target="#createCustomer">Add New</button>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                Customers
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-2">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Phone</th>
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
    // Auto-load Brand list when page is ready
    document.addEventListener('DOMContentLoaded', function() {
        getData();
    });

    // Fetch and render BaseUnits
    async function getData() {
        try {
            showLoader();
            let res = await axios.get("/backendData/customers-list");
            hideLoader();

            let tableList = $("#tableList");
            tableList.empty(); // clear old data

            // Build table rows dynamically
            res.data['data'].forEach(function(item, index) {
                let statusBadge = item['status'] === 'Active'
                    ? '<div class="badge badge-success badge-shadow">Active</div>'
                    : '<div class="badge badge-danger badge-shadow">Inactive</div>';

                let row = `
                <tr>
                    <td>${index + 1}</td>
                    <td>${item['name']}</td>
                    <td>${item['phone']}</td>
                    <td>${statusBadge}</td>
                    <td>
                        <div class="dropdown d-inline">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Actions
                            </button>
                            <div class="dropdown-menu">
                                <button class="dropdown-item has-icon editBtn" data-bs-toggle="modal" data-id="${item['id']}">
                                    <i class="far fa-edit text-warning"></i> Update
                                </button>
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

            // Attach Edit and Delete button events (delegated event listener)
            $(document).off('click', '.editBtn').on('click', '.editBtn', async function () {
                let id = $(this).data('id');
                await GetEditCustomerData(id);
                $('#EditCustomer').modal('show');
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
                    { targets: 0, searchable: false, orderable: false },
                    { targets: [2, 3], orderable: false }
                ],
                order: [[0, "asc"]], // Sort by 'Name' column or change to desired field
                pageLength: 10,
                // Callback to auto-generate serial numbers
                fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    $('td:eq(0)', nRow).html(iDisplayIndexFull + 1);
                    return nRow;
                }
            });

        } catch (e) {
            hideLoader();
            errorToast('Something went wrong')
        }
    }

    // Delete Brand after confirmation
    async function itemDelete(id) {
        try {
            const willDelete = await swal({
                title: 'Are you sure?',
                text: 'Once deleted, you will not be able to recover this file!',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            });

            if (willDelete) {
                showLoader();
                var res = await axios.post("/backendData/customers-delete/", { id: id });
                if (res.data['status'] === 'success') {
                    successToast('Customer deleted successfully');
                    $('#table-2').DataTable().destroy(); // Clear old datatable
                    await getData(); // Reload table
                } else {
                    hideLoader();
                    errorToast(res.data['message']);
                }
            } else {
                swal('Your Customer is safe!');
            }
        } catch (error) {
            hideLoader();
            errorToast(error.response && error.response.data && error.response.data['message']
                ? error.response.data['message']
                : 'An error occurred'
            );
        }
    }
</script>
