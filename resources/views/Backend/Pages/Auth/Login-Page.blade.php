@section('title', 'Login')
@extends('Backend.Layouts.App')
@section('content')
    <div id="app">
        <section class="section">
            <div class="container" style="margin-top: 170px">
                <div class="row">
                    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="card card-primary">
                            <div class="card-header">
                                <a href="{{ route('Dashboard') }}">
                                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="img-fluid">
                                </a>
                            </div>
                            <h4 class="text-center text-danger"><b>Login</b></h4>
                            <hr>
                            <div class="card-body">
                                <form method="POST" action="#" novalidate="">
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input id="username" type="text" class="form-control" value="superadmin" name="username" tabindex="1" placeholder="Username" required>
                                    </div>
                                    <div class="form-group">
                                        <div class="d-block">
                                            <label for="password" class="control-label">Password</label>
                                            <div class="float-right">
                                                <a href="{{ route('Forgot') }}" class="text-small">
                                                    Forgot Password?
                                                </a>
                                            </div>
                                        </div>
                                        <input id="password" type="password" placeholder="Password" value="ffffff" class="form-control" name="password" tabindex="2" required>
                                        <div class="invalid-feedback">
                                            please fill in your password
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-danger btn-lg btn-block" onclick="Login()">
                                            Login
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
        async function Login() {
            try {
                let username = document.getElementById('username').value;
                let password = document.getElementById('password').value;
                if (username.length === 0) {
                    errorToast('Username is required');
                }else if(password.length === 0){
                    errorToast('Password is required');
                } else {
                    showLoader();
                    let res = await axios.post('/backendData/login', {
                        username: username,
                        password: password
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
