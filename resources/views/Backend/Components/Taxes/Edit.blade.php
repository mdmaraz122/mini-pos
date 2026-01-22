<div class="modal fade" id="EditTax"  role="dialog" aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModal">Edit Tax</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="TaxEditForm">
                    <div class="form-group">
                        <label for="edit_name">Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-info"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control" placeholder="Brand Name" id="edit_name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_percentage">Percentage <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-percentage"></i>
                                </div>
                            </div>
                            <input type="number" class="form-control" placeholder="Tax Percentage" id="edit_percentage">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_status">Status</label>
                        <select class="form-control" id="edit_status">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                    <input type="hidden" id="edit_Tax_id">
                    <button type="button" class="btn btn-primary m-t-15 w-100 waves-effect" onclick="updateTax()">Update</button>
                    <button type="button" data-dismiss="modal" id="edit_closeBtn" aria-label="Close" class="btn btn-outline-secondary m-t-15 w-100 waves-effect">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    async function GetEditTaxData(id){
        let res = await axios.post('/backendData/tax-single/', {id: id});
        document.getElementById('edit_name').value = res.data['data']['name'];
        document.getElementById('edit_percentage').value = res.data['data']['percentage'];
        document.getElementById('edit_status').value = res.data['data']['status'];
        document.getElementById('edit_Tax_id').value = res.data['data']['id'];
    }


    // Update Tax
    async function updateTax() {
        try {
            if(!document.getElementById('edit_name').value){
                errorToast('Name is required');
                return;
            }else if(!document.getElementById('edit_percentage').value){
                errorToast('Percentage is required');
                return;
            }else if (isNaN(document.getElementById('edit_percentage').value.trim())){
                errorToast('Percentage must be a number');
                return;
            }
            showLoader();
            let formData = new FormData();
            formData.append('name', document.getElementById('edit_name').value);
            formData.append('percentage', document.getElementById('edit_percentage').value);
            formData.append('status', document.getElementById('edit_status').value);
            formData.append('id', document.getElementById('edit_Tax_id').value);

            let res = await axios.post('/backendData/tax-update', formData);
            if (res.data['status'] === 'success') {
                successToast(res.data['message']);
                document.getElementById('TaxEditForm').reset();
                $('#EditTax').modal('hide');
                $('#table-2').DataTable().destroy();
                await getData();
            } else {
                errorToast(res.data['message']);
                hideLoader();
            }
        } catch (e) {
            hideLoader();
            errorToast('Failed To Update This Tax');
        }
    }
</script>
