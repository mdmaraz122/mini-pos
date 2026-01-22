<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-md-12 text-right">
                    <button class="btn btn-md btn-danger" type="button" data-toggle="modal" data-target="#createTax">Add New</button>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                Orders
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-2">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Customer Name</th>
                                        <th>Order Number</th>
                                        <th>Total</th>
                                        <th>Paid</th>
                                        <th>Due</th>
                                        <th>Date</th>
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

    // Fetch and render Tax
    async function getData() {
        try {
            showLoader();
            let res = await axios.get("/backendData/order-list");
            hideLoader();

            let tableList = $("#tableList");
            tableList.empty(); // clear old data
            console.log(res.data['data']);
            // Build table rows dynamically
            res.data['data'].forEach(function(item, index) {
                // Convert ISO timestamp to readable format
                const createdAt = new Date(item['created_at']);
                const formattedDate = createdAt.toLocaleString('en-US', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: true
                });

                // Determine action based on due amount
                let actionHtml = '';
                if (item['due'] > 0) {
                    actionHtml += `
            <button class="dropdown-item has-icon editBtn" data-bs-toggle="modal" data-id="${item['id']}" data-due="${item['due']}">
                <i class="far fa-eye text-warning"></i> Make Due
            </button>
        `;
                } else {
                    actionHtml += `
            <a class="dropdown-item has-icon" href="order/print/${item['order_number']}">
                <i class="far fa-eye text-warning"></i> Print
            </a>
        `;
                }

                actionHtml += `
        <button class="dropdown-item has-icon deleteBtn" data-bs-toggle="modal" data-id="${item['id']}">
            <i class="fas fa-trash text-danger"></i> Delete
        </button>
    `;

                let row = `
        <tr>
            <td>${index + 1}</td>
            <td>${item['customer']['name']}</td>
            <td>${item['order_number']}</td>
            <td>${item['total_amount']}</td>
            <td>${item['pay']}</td>
            <td>${item['due']}</td>
            <td>${formattedDate}</td>
            <td>
                <div class="dropdown d-inline">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                    </button>
                    <div class="dropdown-menu">
                        ${actionHtml}
                    </div>
                </div>
            </td>
        </tr>
    `;

                tableList.append(row);
            });

            $(document).off('click', '.editBtn').on('click', '.editBtn', async function () {
                let id = $(this).data('id');
                let due = $(this).data('due');
                await FillupData(id, due);
                $('#MakeDue').modal('show');
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
                order: [[1, "desc"]], // Sort by 'Name' column or change to desired field
                pageLength: 10,
                // Callback to auto-generate serial numbers
                fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    $('td:eq(0)', nRow).html(iDisplayIndexFull + 1);
                    return nRow;
                }
            });

        } catch (e) {
            hideLoader();
            console.error(e);
        }
    }

    // Delete Brand after confirmation
    async function itemDelete(id) {
        try {
            const willDelete = await swal({
                title: 'Are you sure?',
                text: 'Once deleted, you will not be able to recover this data!',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            });

            if (willDelete) {
                showLoader();
                var res = await axios.post("/backendData/order-delete", { id: id });
                if (res.data['status'] === 'success') {
                    swal('Poof! Order has been deleted!', {
                        icon: 'success',
                    });
                    $('#table-2').DataTable().destroy(); // Clear old datatable
                    await getData(); // Reload table
                } else {
                    hideLoader();
                    errorToast(res.data['message']);
                }
            } else {
                swal('Your Order is safe!');
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
