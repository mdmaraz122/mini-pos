<div class="modal fade" id="createCustomer"  role="dialog" aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModal">Create Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="CustomerCreateForm">
                    <div class="form-group">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-info"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control" placeholder="Customer Name" id="name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-phone"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control" placeholder="Customer Phone Number" id="phone">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-home"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control" placeholder="Customer Address" id="address">
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary m-t-15 w-100 waves-effect" onclick="createCustomer()">Create</button>
                    <button type="button" data-dismiss="modal" id="closeBtn" aria-label="Close" class="btn btn-outline-secondary m-t-15 w-100 waves-effect">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    // create BaseUnit
    async function createCustomer() {
        try {
            if(!document.getElementById('name').value){
                errorToast('Name is required');
            }else if(!document.getElementById('phone').value){
                errorToast('Name is required');
            }else {
                showLoader();
                let formData = new FormData();
                formData.append('name', document.getElementById('name').value);
                formData.append('phone', document.getElementById('phone').value);
                formData.append('address', document.getElementById('address').value);
                let res = await axios.post('/backendData/customer-create', formData);
                if (res.data['status'] === 'success') {
                    successToast(res.data['message']);
                    document.getElementById('CustomerCreateForm').reset();
                    $('#table-2').DataTable().destroy();
                    await getData();
                    $('#closeBtn').click();
                } else {
                    errorToast(res.data['message']);
                    hideLoader();
                }
            }
        } catch (e) {
            hideLoader();
            errorToast('Failed to Create Base Unit');
        }
    }
</script>
