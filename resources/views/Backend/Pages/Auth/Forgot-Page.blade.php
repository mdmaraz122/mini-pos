@section('title', 'Forgot Password')
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
                            <h4 class="text-center text-danger"><b>Forgot Password</b></h4>
                            <hr>
                            <div class="card-body">
                                <form method="POST" action="#" novalidate="">
                                    <div class="form-group">
                                        <label for="secret_code">Secret Code</label>
                                        <input id="secret_code" type="text" class="form-control" name="secret_code" tabindex="1" placeholder="Secret Code" required>
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-danger btn-lg btn-block" onclick="ForgotPassword()">
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
        async function ForgotPassword() {
            try {
                let secret_code = document.getElementById('secret_code').value;
                if (secret_code.length === 0) {
                    errorToast('Secret Code is required');
                }else {
                    showLoader();
                    let res = await axios.post('/backendData/forgot', {
                        secret_code: secret_code
                    })
                    hideLoader();
                    if (res.data['status'] === 'error') {
                        errorToast(res.data['message']);
                    }else if(res.data['status'] === 'success'){
                        successToast(res.data['message']);
                        setTimeout(() => {
                            window.location.href = '/reset';
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
