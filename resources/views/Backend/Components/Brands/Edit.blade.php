<div class="modal fade" id="EditBrand"  role="dialog" aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModal">Edit Brand</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="BrandEditForm">
                    <div class="form-group">
                        <label for="edit_image">Image <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-image"></i>
                                </div>
                            </div>
                            <input type="file" id="edit_image" class="form-control" oninput="edit_showImage.src=window.URL.createObjectURL(this.files[0])">
                        </div>
                        <img width="60px" id="edit_showImage" alt="Image" height="60px" class="border-danger border mt-3" src="{{ asset('assets/images/default.jpg') }}">
                    </div>
                    <div class="form-group">
                        <label for="edit_name">Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-info"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control" oninput="editTextToSlug()" placeholder="Brand Name" id="edit_name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_slug">Slug <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-info"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control" disabled placeholder="Brand Slug" id="edit_slug">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_status">Status</label>
                        <select class="form-control" id="edit_status">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                    <input type="hidden" id="edit_Brand_id">
                    <button type="button" class="btn btn-primary m-t-15 w-100 waves-effect" onclick="updateBrand()">Update</button>
                    <button type="button" data-dismiss="modal" id="edit_closeBtn" aria-label="Close" class="btn btn-outline-secondary m-t-15 w-100 waves-effect">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    // fetch to get data
    async function GetEditBrandData(id){
        let res = await axios.post('/backendData/brand-single/', {id: id});
        if(res.data['data']['image'] === null){
            document.getElementById('edit_showImage').src = '{{ asset('assets/images/default.jpg') }}';
        } else {
            document.getElementById('edit_showImage').src = '/assets/uploads/brands/' + res.data['data']['image'];
        }
        document.getElementById('edit_name').value = res.data['data']['name'];
        document.getElementById('edit_slug').value = res.data['data']['slug'];
        document.getElementById('edit_status').value = res.data['data']['status'];
        document.getElementById('edit_Brand_id').value = res.data['data']['id'];
    }

    // Update Brand
    async function updateBrand() {
        try {
            if(!document.getElementById('edit_name').value){
                errorToast('Name is required');
                return;
            } else if(!document.getElementById('edit_slug').value){
                errorToast('Slug is required');
                return;
            }
            showLoader();
            let formData = new FormData();

            // Only append image if a new one is selected
            if (document.getElementById('edit_image').files.length > 0) {
                formData.append('image', document.getElementById('edit_image').files[0]);
            }
            formData.append('name', document.getElementById('edit_name').value);
            formData.append('slug', document.getElementById('edit_slug').value);
            formData.append('status', document.getElementById('edit_status').value);
            formData.append('id', document.getElementById('edit_Brand_id').value);

            let res = await axios.post('/backendData/brand-update', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });
            if (res.data['status'] === 'success') {
                successToast(res.data['message']);
                document.getElementById('edit_showImage').src = '{{ asset('assets/images/default.jpg') }}';
                document.getElementById('BrandEditForm').reset();
                $('#EditBrand').modal('hide');
                $('#table-2').DataTable().destroy();
                await getData();
            } else {
                errorToast(res.data['message']);
                hideLoader();
            }
        } catch (e) {
            hideLoader();
            errorToast('Failed to Update Brand');
        }
    }
    // text to slug
    function editTextToSlug(){
        let name = document.getElementById('edit_name').value;
        document.getElementById('edit_slug').value = name.replace(/\s+/g, '-').toLowerCase();
    }
</script>
