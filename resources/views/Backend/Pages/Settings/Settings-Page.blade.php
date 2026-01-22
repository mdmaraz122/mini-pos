@section('title', 'Settings')
@extends('Backend.Layouts.Master')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    Settings
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="shopName">Shop Name <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-store"></i>
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Shop Name" id="shopName">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="shopAddress">Shop Address <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-store"></i>
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Shop Address" id="shopAddress">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="shopPhone">Shop Phone Number <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-phone"></i>
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Shop Phone Number" id="shopPhone">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="ReceiptMessage">Sell Receipt Note</label>
                                            <div class="input-group">
                                                <textarea type="text" class="form-control" placeholder="Receipt Message" id="ReceiptMessage"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="button" onclick="updateSettings()" class="btn btn-sm btn-danger w-100">Update</button>
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
        async function updateSettings() {
            try {
                if(!document.getElementById('shopName').value){
                    errorToast('Shop Name is required');
                }else if(!document.getElementById('shopAddress').value){
                    errorToast('Shop Address is required');
                }else if(!document.getElementById('shopPhone').value){
                    errorToast('Shop Phone is required');
                }else {
                    showLoader();
                    let formData = new FormData();
                    formData.append('name', document.getElementById('shopName').value);
                    formData.append('address', document.getElementById('shopAddress').value);
                    formData.append('phone', document.getElementById('shopPhone').value);
                    formData.append('ReceiptMessage', document.getElementById('ReceiptMessage').value);
                    let res = await axios.post('/backendData/setting-update', formData);
                    if (res.data['status'] === 'success') {
                        successToast(res.data['message']);
                        await getData();
                    } else {
                        errorToast(res.data['message']);
                        hideLoader();
                    }
                }
            } catch (e) {
                hideLoader();
                errorToast('Failed to update settings');
            }
        }
        // get data
        document.addEventListener('DOMContentLoaded', function() {
            getData();
        });
        async function getData() {
            try {
                showLoader();
                let res = await axios.get('/backendData/get-setting');
                console.log(res.data['data']);
                    document.getElementById('shopName').value = res.data['data']['shop_name'];
                    document.getElementById('shopAddress').value = res.data['data']['shop_address'];
                    document.getElementById('shopPhone').value = res.data['data']['shop_phone'];
                    document.getElementById('ReceiptMessage').value = res.data['data']['receipt_message'];
                hideLoader();
            } catch (e) {
                errorToast('Failed to update settings');
            }
        }
    </script>
@endsection

