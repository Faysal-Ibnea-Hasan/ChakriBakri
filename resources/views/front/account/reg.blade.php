@extends('front.layouts.app')

@section('main')
    <section class="section-5">
        <div class="container my-5">
            <div class="py-lg-2">&nbsp;</div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-5">
                    <div class="card shadow border-0 p-5">
                        <h1 class="h3">Register</h1>
                        <form action="" name="regForm" id="regForm">
                            <div class="mb-3">
                                <label for="" class="mb-2">Name*</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Enter Name">
                                <p></p>
                            </div>
                            <div class="mb-3">
                                <label for="" class="mb-2">Email*</label>
                                <input type="text" name="email" id="email" class="form-control"
                                    placeholder="Enter Email">
                                <p></p>
                            </div>
                            <div class="mb-3">
                                <label for="" class="mb-2">Password*</label>
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="Enter Password">
                                <p></p>
                            </div>
                            <div class="mb-3">
                                <label for="" class="mb-2">Confirm Password*</label>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                                    placeholder="Please confirm Password">
                                <p></p>
                            </div>
                            <button class="btn btn-primary mt-2">Register</button>
                        </form>
                    </div>
                    <div class="mt-4 text-center">
                        <p>Have an account? <a href="login.html">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJs')
    <script>
        // Attach a submit event listener to the registration form
        $('#regForm').submit(function(e) {
            // Prevent the default form submission behavior
            e.preventDefault();

            // Perform an AJAX POST request to submit the form data
            $.ajax({
                url: '{{ route('account.reg.process') }}', // URL to send the request to
                type: "post", // HTTP method
                data: $('#regForm').serializeArray(), // Serialize form data for submission
                dataType: 'json', // Expected response data type

                // Callback function to handle a successful response
                success: function(response) {
                    // If validation fails, handle errors
                    if (response.status == false) {
                        var errors = response.errors;

                        // Handle name field errors
                        if (errors.name) {
                            $("#name").addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                                .html(errors.name);
                        } else {
                            $('#name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback')
                                .html('');
                        }

                        // Handle email field errors
                        if (errors.email) {
                            $("#email").addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                                .html(errors.email);
                        } else {
                            $('#email').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback')
                                .html('');
                        }

                        // Handle password field errors
                        if (errors.password) {
                            $("#password").addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                                .html(errors.password);
                        } else {
                            $('#password').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback')
                                .html('');
                        }

                        // Handle confirm_password field errors
                        if (errors.confirm_password) {
                            $("#confirm_password").addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                                .html(errors.confirm_password);
                        } else {
                            $('#confirm_password').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback')
                                .html('');
                        }

                    } else {
                        // If validation passes, clear any previous errors
                        $('#name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback')
                            .html('');
                        $('#email').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback')
                            .html('');
                        $('#password').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback')
                            .html('');
                        $('#confirm_password').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback')
                            .html('');

                        // Redirect to the login page upon successful registration
                        window.location.href = "{{ route('account.login') }}";
                    }
                }
            });
        });
    </script>
@endsection

