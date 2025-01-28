@extends('layouts.user_type.guest')

@section('content')

<main class="main-content mt-0">
    <section>
        <div class="page-header min-vh-75">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                        <div class="card card-plain mt-8">
                            <div class="card-header pb-0 text-left bg-transparent">
                                <h3 class="font-weight-bolder text-warning text-gradient">Welcome to GasByGas</h3>
                                <p class="mb-0">Sign in with your credentials</p>
                            </div>
                            <div class="card-body">
                                <form id="login-form" role="form" method="POST">
                                    @csrf
                                    <label>Email</label>
                                    <div class="mb-3">
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="" aria-label="Email" aria-describedby="email-addon">
                                        @error('email')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <label>Password</label>
                                    <div class="mb-3">
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="" aria-label="Password" aria-describedby="password-addon">
                                        @error('password')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="rememberMe" checked="">
                                        <label class="form-check-label" for="rememberMe">Remember me</label>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-warning w-100 mt-4 mb-0">Sign in</button>
                                    </div>
                                </form>
                            </div>
                            <div id="login-response"></div>
                            <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                <small class="text-muted">Forgot you password? Reset you password
                                    <a href="/login/forgot-password" class="text-info text-gradient font-weight-bold">here</a>
                                </small>
                                <p class="mb-4 text-sm mx-auto">
                                    Don't have a customer account?
                                    <a href="register" class="text-info text-gradient font-weight-bold">Register</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                            <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('../assets/img/curved-images/curved6.jpg')"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
    $(document).ready(function() {
        $('#login-form').on('submit', function(e) {
            e.preventDefault();

            // Get CSRF token from meta tag
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            // Collect form data
            const email = $('#email').val();
            const password = $('#password').val();

            // Make an AJAX POST request
            $.ajax({
                url: '/api/v1/login',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken, // CSRF token for Laravel
                    'Accept': 'application/json',
                },
                contentType: 'application/json',
                data: JSON.stringify({
                    email: email,
                    password: password,
                }),
                xhrFields: {
                    withCredentials: true, // Ensures cookies are sent
                },
                success: function(loginResponse) {
                    $.ajax({
                        url: '/api/v1/me',
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'Authorization': `Bearer ${loginResponse.access_token}`
                        },
                        contentType: 'application/json',
                        xhrFields: {
                            withCredentials: true,
                        },
                        success: function(response) {
                            localStorage.setItem('me', JSON.stringify(response.data));
                            localStorage.setItem('access_token', JSON.stringify(loginResponse.access_token));
                            if (loginResponse.user.type === "ADMIN") {
                                window.location.href = "/admin/dashboard";
                            }
                            if (loginResponse.user.type === "OUTLET_MANAGER") {
                                window.location.href = "/outlet/dashboard";
                            }
                            if (loginResponse.user.type === "CONSUMER") {
                                window.location.href = "/consumer/dashboard";
                            }
                        },
                        error: function(xhr) {
                            const error = xhr.responseJSON?.message || 'An error occurred';
                            $('#login-response').html(`<p>Error: ${error}</p>`);
                        },
                    });
                },
                error: function(xhr) {
                    const error = xhr.responseJSON?.message || 'An error occurred';
                    $('#login-response').html(`<p>Error: ${error}</p>`);
                },
            });
        });
    });
</script>


@endsection
