<div class="modal fade" id="MakeDue"  role="dialog" aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModal">Make Due</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="MakeDueForm">
                    <div class="form-group">
                        <label for="due_amount">Due Amount <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    ﷼
                                </div>
                            </div>
                            <input type="number" class="form-control" placeholder="Due Amount" id="due_amount">
                        </div>
                    </div>
                    <input type="hidden" id="edit_MakeDue_id">
                    <button type="button" class="btn btn-primary m-t-15 w-100 waves-effect" onclick="MakePayment()">Update</button>
                    <button type="button" data-dismiss="modal" id="edit_closeBtn" aria-label="Close" class="btn btn-outline-secondary m-t-15 w-100 waves-effect">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    async function FillupData(id, due){
        document.getElementById('edit_MakeDue_id').value = id;
        document.getElementById('due_amount').value = due;
    }

    // Update SubCategory
    async function MakePayment() {
        try {
            if(!document.getElementById('due_amount').value){
                errorToast('Due Amount Is Required');
                return;
            }
            if(document.getElementById('due_amount').value < 0){
                errorToast('Due Amount cannot be negative');
                return;
            }


            showLoader();
            let formData = new FormData();
            formData.append('due_amount', document.getElementById('due_amount').value);
            formData.append('id', document.getElementById('edit_MakeDue_id').value);

            let res = await axios.post('/backendData/make-due-payment', formData);
            if (res.data['status'] === 'success') {
                successToast(res.data['message']);
                document.getElementById('MakeDueForm').reset();
                $('#MakeDue').modal('hide');
                $('#table-2').DataTable().destroy();
                await getData();
            } else {
                errorToast(res.data['message']);
                hideLoader();
            }
        } catch (e) {
            hideLoader();
            console.error(e);
            errorToast('Failed to Update Due Payment');
        }
    }
</script>
