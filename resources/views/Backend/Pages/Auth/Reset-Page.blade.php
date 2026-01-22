@section('title', 'Reset Password')
@extends('Backend.Layouts.App')
@section('content')
    <div id="app">
        <section class="section ">
            <div class="container" style="margin-top: 170px">
                <div class="row">
                    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="card card-primary">
                            <div class="card-header">
                                <a href="{{ route('Dashboard') }}">
                                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="img-fluid">
                                </a>
                            </div>
                            <h4 class="text-center text-danger"><b>Reset Password</b></h4>
                            <hr>
                            <div class="card-body">
                                <form method="POST" action="#" novalidate="">
                                    <div class="form-group">
                                        <label for="password">New Password</label>
                                        <input id="password" type="password" class="form-control" name="secret_code" tabindex="1" placeholder="Password" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirmPassword">Confirm Password</label>
                                        <input id="confirmPassword" type="password" class="form-control" name="confirmPassword" tabindex="1" placeholder="Confirm Password" required>
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-danger btn-lg btn-block" onclick="ResetPassword()">
                                            Submit
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        async function ResetPassword() {
            try {
                let password = document.getElementById('password').value;
                let confirmPassword = document.getElementById('confirmPassword').value;
                if (password.length === 0) {
                    errorToast('Password is required');
                }else if( password.length < 6) {
                    errorToast('Password must be at least 6 characters long');
                }else if (confirmPassword.length === 0) {
                    errorToast('Confirm Password is required');
                }else if (password !== confirmPassword) {
                    errorToast('Password & Confirm Password Does Not Matched');
                } else {
                    showLoader();
                    let res = await axios.post('/backendData/reset', {
                        password: password,
                        confirmPassword: confirmPassword,
                    })
                    hideLoader();
                    if (res.data['status'] === 'error') {
                        errorToast(res.data['message']);
                    }else if(res.data['status'] === 'success'){
                        successToast(res.data['message']);
                        setTimeout(() => {
                            window.location.href = '/';
                        }, 1000);
                    }
                }
            }catch (e) {
                hideLoader();
                errorToast('Something went wrong');
            }
        }
    </script>
@endsection
