@extends('layouts.user_type.guest')

@section('content')

<section class="min-vh-90 mb-1">
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11 mx-3 border-radius-lg" style="background-image: url('../assets/img/curved-images/curved14.jpg');border-top-left-radius: 0px;border-top-right-radius: 0px;">
        <span class="mask bg-gradient-dark opacity-6"></span>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 text-center mx-auto">
                    <h1 class="text-white mb-2 mt-5">Welcome!</h1>
                    <p class="text-lead text-white">Register to the GasByGas as a costomer by filling the bellow details.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row mt-lg-n10 mt-md-n11 mt-n10">
            <div class="col-xl-6 col-lg-6 col-md-7 mx-auto">
                <div class="card z-index-0">
                    <div class="card-body">
                        <form role="form text-left" method="POST" id="consumer-register-form">
                            @csrf
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="new-consumer-email" class="form-control-label">Email</label>
                                        <input class="form-control" type="email" required placeholder="abc@gasbygas.com" id="new-consumer-email">
                                        @error('email')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="new-consumer-phoneNo" class="form-control-label">Phone No</label>
                                        <input class="form-control" type="text" required placeholder="+94 123456789" id="new-consumer-phoneNo">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="new-consumer-type" class="form-control-label">User Type</label>
                                        <select class="form-control" id="new-consumer-type">
                                            <option value="-1">~ Register as ~</option>
                                            <option value="CUSTOMER">Individual Customer</option>
                                            <option value="BUSINESS">Industrial Customer</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="new-consumer-nic" class="form-control-label">NIC</label>
                                        <input class="form-control" type="text" required placeholder="812639841V or 200318300501" id="new-consumer-nic">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="new-consumer-businessNo" class="form-control-label">Business Registration No</label>
                                        <input class="form-control" type="text" readonly placeholder="RT-2304DF" id="new-consumer-businessNo">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="new-consumer-password" class="form-control-label">Password</label>
                                        <input class="form-control" type="password" required placeholder="John" id="new-consumer-password">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="new-consumer-confirm-password" class="form-control-label">Confirm Password</label>
                                        <input class="form-control" type="password" required placeholder="John" id="new-consumer-confirm-password">
                                    </div>
                                </div>
                                <div id="password-error" class=" text-danger"></div>
                            </div>
                            <div class="form-check form-check-info text-left">
                                <input class="form-check-input" type="checkbox" required name="agreement" id="new-consumer-agreement">
                                <label class="form-check-label" for="new-consumer-agreement">
                                    I agree the <a href="javascript:;" class="text-dark font-weight-bolder">Terms and Conditions</a>
                                </label>
                                @error('agreement')
                                <p class="text-danger text-xs mt-2">First, agree to the Terms and Conditions, then try register again.</p>
                                @enderror
                            </div>
                            <div id="register-response" class="text-danger"></div>
                            <div class="text-center">
                                <button type="submit" class="btn bg-gradient-warning w-100 my-4 mb-2">Register</button>
                            </div>
                            <p class="text-sm mt-3 mb-0">Already have a customer account? <a href="login" class="text-dark font-weight-bolder">Login in</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function() {
        setupSelectChangeHandlers();

        $('#consumer-register-form').on('submit', function(e) {
            e.preventDefault();

            // Get CSRF token from meta tag
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            // Collect form data
            const password = $('#new-consumer-password').val();
            const conPassword = $('#new-consumer-confirm-password').val();

            if (password !== conPassword) {
                $('#password-error').html(`<p>Password not match. Make sure confirm password is match to the password</p>`);
                return;
            }

            const email = $('#new-consumer-email').val();
            const phone_no = $('#new-consumer-phoneNo').val();
            const type = $('#new-consumer-type').val();
            const nic = $('#new-consumer-nic').val();
            const business_no = $('#new-consumer-businessNo').val();

            const agreement = $('#new-consumer-agreement').val();

            $.ajax({
                url: '/api/v1/register',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                contentType: 'application/json',
                data: JSON.stringify({
                    email: email,
                    password: password,
                    phone_no: phone_no,
                    type: type,
                    nic: nic,
                    business_no: business_no,
                    agreement: agreement
                }),
                xhrFields: {
                    withCredentials: true,
                },
                success: function(registerResponse) {
                    $.ajax({
                        url: '/api/v1/me',
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        },
                        contentType: 'application/json',
                        xhrFields: {
                            withCredentials: true,
                        },
                        success: function(response) {
                            localStorage.setItem('me', JSON.stringify(response.data));
                            if (registerResponse.user.type === "CONSUMER") {
                                window.location.href = "/consumer/dashboard";
                            }
                        },
                        error: function(xhr) {
                            const error = xhr.responseJSON?.message || 'An error occurred';
                            $('#register-response').html(`<p>Error: ${error}</p>`);
                        },
                    });
                },
                error: function(xhr) {
                    const error = xhr.responseJSON?.message || 'An error occurred';
                    $('#register-response').html(`<p>Error: ${error}</p>`);
                },
            });

        });
    });

    function setupSelectChangeHandlers() {
        $('#new-consumer-type').on('change', function() {
            switch (this.value) {
                case 'BUSINESS':
                    $('#new-consumer-businessNo').attr("readonly", false);
                    break;
                default:
                    $('#new-consumer-businessNo').attr("readonly", true);
                    break;
            }
        });
    }
</script>

@endsection
