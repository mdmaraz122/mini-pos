<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row mt-sm-4">
                <div class="col-4">
                    <div class="card author-box">
                        <div class="card-body">
                            <div class="author-box-center">
                                <img alt="image" id="image" src="" class="rounded-circle author-box-picture">
                                <div class="clearfix"></div>
                                <div class="author-box-name">
                                    <h5 class="mt-3 text-danger">{{ $admin->username }}</h5>
                                </div>
                                <div class="author-box-job">Super Admin</div>
                            </div>
                        </div>
                    </div>
                    <div class="card author-box mt-5">
                        <div class="card-body">
                            <h4 class="text-danger">Password</h4>
                            <hr>
                            <form id="passwordUpdateForm">
                                <div class="row">
                                    <div class="col-md-12 mt-3">
                                        <label for="current_password" class="text-dark">Current Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="current_password" placeholder="Current Password">
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <label for="new_password" class="text-dark">New Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="new_password" placeholder="New Password">
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <label for="confirm_password" class="text-dark">Confirm Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="confirm_password" placeholder="Confirm Password">
                                    </div>
                                    <div class="col-md-12 mt-4">
                                        <button type="button" onclick="updatePassword()" class="btn btn-md text-dark btn-warning w-100">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card author-box">
                        <div class="card-body">
                            <h4 class="text-danger">Profile</h4>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 mt-2">
                                    <label for="file" class="text-dark">Profile Image</label>
                                    <div class="input-group mb-3">
                                        <input type="file" class="form-control" oninput="image.src=window.URL.createObjectURL(this.files[0])" id="inputGroupFile02">
                                        <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label for="username" class="text-dark">Username <span class="text-danger">*</span></label>
                                    <input class="form-control" placeholder="Username" id="username" value="{{ $admin->username }}" disabled>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <label for="first_name" class="text-dark">First Name <span class="text-danger">*</span></label>
                                    <input class="form-control" placeholder="First Name" id="first_name">
                                </div>
                                <div class="col-md-4 mt-2">
                                    <label for="middle_name" class="text-dark">Middle Name</label>
                                    <input class="form-control" placeholder="Middle Name" id="middle_name">
                                </div>
                                <div class="col-md-4 mt-2">
                                    <label for="last_name" class="text-dark">Last Name <span class="text-danger">*</span></label>
                                    <input class="form-control" placeholder="Last Name" id="last_name">
                                </div>
                                <div class="col-md-4 mt-2">
                                    <label for="email" class="text-dark">Email Address <span class="text-danger">*</span></label>
                                    <input class="form-control" placeholder="Email Address" disabled id="email">
                                </div>
                                <div class="col-md-4 mt-2">
                                    <label for="phone" class="text-dark">Phone Number <span class="text-danger">*</span></label>
                                    <input class="form-control" placeholder="Phone Number" disabled id="phone">
                                </div>
                                <div class="col-md-4 mt-2">
                                    <label for="gender" class="text-dark">Gender</label>
                                    <select class="form-control" id="gender">
                                        <option>Select Gender</option>
                                        <option class="male">Male</option>
                                        <option class="female">Female</option>
                                        <option class="other">Other</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label for="dob" class="text-dark">Date Of Birth</label>
                                    <input class="form-control" id="dob" type="date">
                                </div>
                                <div class="col-md-12 mt-4">
                                    <button type="button" onclick="updateProfileData()" class="btn btn-md btn-warning text-dark w-100">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        getProfileData();
    });
    // Get Profile Data And Show In Form
    async function getProfileData() {
        try {
            showLoader();

            let res = await axios.get('/backendData/profile');

            document.getElementById('first_name').value = res.data['data'].first_name || '';
            document.getElementById('middle_name').value = res.data['data'].middle_name || '';
            document.getElementById('last_name').value = res.data['data'].last_name || '';
            document.getElementById('email').value = res.data['data'].email || '';
            document.getElementById('phone').value = res.data['data'].phone || '';
            document.getElementById('gender').value = res.data['data'].gender || '';
            document.getElementById('dob').value = res.data['data'].dob || '';

            let defaultImage = '/assets/backend/img/users/user-3.png';
            let imageElement = document.getElementById('image');
            imageElement.src = res.data['data'].image
                ? '/assets/uploads/profile/' + res.data['data'].image
                : defaultImage;

            hideLoader();
        } catch (e) {
            hideLoader();
            errorToast('Something went wrong');
        }
    }

    // Update Profile Date
    async function updateProfileData() {
        try {
            showLoader();

            // Validate required fields
            const firstName = document.getElementById('first_name').value.trim();
            const lastName = document.getElementById('last_name').value.trim();

            if (!firstName) {
                errorToast('First Name is required');
                hideLoader();
                return;
            }
            if (!lastName) {
                errorToast('Last Name is required');
                hideLoader();
                return;
            }

            // Prepare form data
            const formData = new FormData();
            formData.append('first_name', firstName);
            formData.append('middle_name', document.getElementById('middle_name').value.trim());
            formData.append('last_name', lastName);
            formData.append('gender', document.getElementById('gender').value);
            formData.append('dob', document.getElementById('dob').value);

            // Handle profile image
            const fileInput = document.getElementById('inputGroupFile02');
            if (fileInput.files[0]) {
                formData.append('image', fileInput.files[0]);
            }

            // Send request
            const res = await axios.post('/backendData/profile/update', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });

            if (res.data.status === 'success') {
                successToast(res.data.message);
                await getProfileData(); // refresh the form after update
            } else {
                errorToast(res.data.message || 'Update failed');
            }
        } catch (error) {
            errorToast(error.response?.data?.message || 'Something went wrong during update');
            console.error('Update error:', error);
        } finally {
            hideLoader();
        }
    }
    // Update Password
    async function updatePassword() {
        try {
            // Validate form data
            if (document.getElementById('current_password').value === '') {
                errorToast('Current Password is required');
                return;
            }
            if (document.getElementById('new_password').value === '') {
                errorToast('New Password is required');
                return;
            }
            if( document.getElementById('new_password').value.length < 6) {
                errorToast('New Password must be at least 6 characters long');
                return;
            }
            if (document.getElementById('confirm_password').value === '') {
                errorToast('Confirm Password is required');
                return;
            }
            if (document.getElementById('new_password').value !== document.getElementById('confirm_password').value) {
                errorToast('New Password and Confirm Password do not match');
                return;
            }
            // Prepare form data
            let formData = new FormData();
            formData.append('current_password', document.getElementById('current_password').value);
            formData.append('new_password', document.getElementById('new_password').value);
            formData.append('confirm_password', document.getElementById('confirm_password').value);
            showLoader();
            // Send request
            let res = await axios.post('/backendData/profile/changePassword', formData);
            if (res.data['status'] === 'success') {
                successToast(res.data['message']);
                document.getElementById('passwordUpdateForm').reset();
                hideLoader();
            } else {
                errorToast(res.data['message']);
                hideLoader();
            }

        } catch (e) {
            hideLoader();
            errorToast(e);
        }
    }
</script>
