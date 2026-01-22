<div class="modal fade" id="createCategory"  role="dialog" aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModal">Create Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="categoryCreateForm">
                    <div class="form-group">
                        <label for="image">Image</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-image"></i>
                                </div>
                            </div>
                            <input type="file" id="image" class="form-control" oninput="showImage.src=window.URL.createObjectURL(this.files[0])">
                        </div>
                        <img width="60px" id="showImage" alt="Image" height="60px" class="border-danger border mt-3" src="{{ asset('assets/images/default.jpg') }}">
                    </div>
                    <div class="form-group">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-info"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control" oninput="textToSlug()" placeholder="Category Name" id="name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="slug">Slug <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-info"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control" disabled placeholder="Category Slug" id="slug">
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary m-t-15 w-100 waves-effect" onclick="createCategory()">Create</button>
                    <button type="button" data-dismiss="modal" id="closeBtn" aria-label="Close" class="btn btn-outline-secondary m-t-15 w-100 waves-effect">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    // create category
    async function createCategory() {
        try {
            if(!document.getElementById('name').value){
                errorToast('Name is required');
            }else if(!document.getElementById('slug').value){
                errorToast('Slug is required');
            }else {
                showLoader();
                let formData = new FormData();
                formData.append('image', document.getElementById('image').files[0]);
                formData.append('name', document.getElementById('name').value);
                formData.append('slug', document.getElementById('slug').value);
                let res = await axios.post('/backendData/category-create', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                if (res.data['status'] === 'success') {
                    successToast(res.data['message']);
                    document.getElementById('showImage').src = '{{ asset('assets/images/default.jpg') }}';
                    document.getElementById('categoryCreateForm').reset();
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
            errorToast('Failed to Create Category');
        }
    }
    // text to slug
    function textToSlug(){
        let name = document.getElementById('name').value;
        document.getElementById('slug').value = name.replace(/\s+/g, '-').toLowerCase();
    }
</script>
