<div class="modal fade" id="EditUnitsModel"  role="dialog" aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModal">Edit Unit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="UnitEditForm">
                    <div class="form-group">
                        <label for="edit_name">Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-info"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control" placeholder="Base Unit Name" id="edit_name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_status">Status</label>
                        <select class="form-control" id="edit_status">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                    <input type="hidden" id="edit_unit_id">
                    <button type="button" class="btn btn-primary m-t-15 w-100 waves-effect" onclick="updateBaseUnit()">Update</button>
                    <button type="button" data-dismiss="modal" id="edit_closeBtn" aria-label="Close" class="btn btn-outline-secondary m-t-15 w-100 waves-effect">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    async function GetEditBaseUnitData(id){
        let res = await axios.post('/backendData/units-single/', {id: id});
        document.getElementById('edit_name').value = res.data['data']['name'];
        document.getElementById('edit_status').value = res.data['data']['status'];
        document.getElementById('edit_unit_id').value = res.data['data']['id'];
    }


    // Update Tax
    async function updateBaseUnit() {
        try {
            if(!document.getElementById('edit_name').value){
                errorToast('Name is required');
                return;
            }
            showLoader();
            let formData = new FormData();
            formData.append('name', document.getElementById('edit_name').value);
            formData.append('status', document.getElementById('edit_status').value);
            formData.append('id', document.getElementById('edit_unit_id').value);

            let res = await axios.post('/backendData/units-update', formData);
            if (res.data['status'] === 'success') {
                successToast(res.data['message']);
                document.getElementById('UnitEditForm').reset();
                $('#EditUnitsModel').modal('hide');
                $('#table-2').DataTable().destroy();
                await getData();
            } else {
                errorToast(res.data['message']);
                hideLoader();
            }
        } catch (e) {
            hideLoader();
            console.error(e);
            errorToast('Failed to Update Unit');
        }
    }
</script>
