<div class="modal fade" id="createTax"  role="dialog" aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModal">Create Tax</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="TaxCreateForm">
                    <div class="form-group">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-info"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control" placeholder="Tax Name" id="name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="percentage">Percentage <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-percentage"></i>
                                </div>
                            </div>
                            <input type="number" class="form-control" placeholder="Tax Percentage" id="percentage">
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary m-t-15 w-100 waves-effect" onclick="createTax()">Create</button>
                    <button type="button" data-dismiss="modal" id="closeBtn" aria-label="Close" class="btn btn-outline-secondary m-t-15 w-100 waves-effect">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    // create Tax
    async function createTax() {
        try {
            if(!document.getElementById('name').value){
                errorToast('Name is required');
            }else if(!document.getElementById('percentage').value){
                errorToast('Percentage is required');
            }else if (isNaN(document.getElementById('percentage').value.trim())){
                errorToast('Percentage must be a number');
            } else {
                showLoader();
                let formData = new FormData();
                formData.append('name', document.getElementById('name').value);
                formData.append('percentage', document.getElementById('percentage').value);
                let res = await axios.post('/backendData/tax-create', formData);
                if (res.data['status'] === 'success') {
                    successToast(res.data['message']);
                    document.getElementById('TaxCreateForm').reset();
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
            errorToast('Failed To Create This Tax');
        }
    }
</script>
