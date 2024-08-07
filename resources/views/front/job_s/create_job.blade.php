@extends('front.layouts.app')

@section('main')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Account Settings</li>
                        </ol>
                    </nav>
                </div>
            </div>
            @if (Session::has('success'))
                <!-- Display success message if it exists in the session -->
                <div class="alert alert-success">
                    <p>{{ Session::get('success') }}</p>
                </div>
            @endif
            <div class="row">
                <div class="col-lg-3">
                    @include('front.account.sidebar')
                </div>
                <div class="col-lg-9">

                    <div class="col-lg-9">
                        <form action="" id="postJob" name="postJob" method="POST">
                            <div class="card border-0 shadow mb-4 ">
                                <div class="card-body card-form p-4">
                                    <h3 class="fs-4 mb-1">Job Details</h3>
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label for="" class="mb-2">Title<span class="req">*</span></label>
                                            <input type="text" placeholder="Job Title" id="title" name="title"
                                                class="form-control">
                                            <p></p>
                                        </div>
                                        <div class="col-md-6  mb-4">
                                            <label for="" class="mb-2">Category<span
                                                    class="req">*</span></label>
                                            <select name="catagory_id" id="catagory_id" class="form-control">
                                                <option value="">Select a Category</option>
                                                @if ($catagories->isNotEmpty())
                                                    @foreach ($catagories as $catagory)
                                                        <option value="{{ $catagory->id }}">{{ $catagory->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label for="" class="mb-2">Job Nature<span
                                                    class="req">*</span></label>
                                            <select class="form-select" name="job_type_id" id="job_type_id">
                                                <option value="">Select Job Nature</option>
                                                @if ($jobTypes->isNotEmpty())
                                                    @foreach ($jobTypes as $jobType)
                                                        <option value="{{ $jobType->id }}">{{ $jobType->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <p></p>
                                        </div>
                                        <div class="col-md-6  mb-4">
                                            <label for="" class="mb-2">Vacancy<span
                                                    class="req">*</span></label>
                                            <input type="number" min="1" placeholder="Vacancy" id="vacancy"
                                                name="vacancy" class="form-control">
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="mb-4 col-md-6">
                                            <label for="" class="mb-2">Salary</label>
                                            <input type="text" placeholder="Salary" id="salary" name="salary"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label for="" class="mb-2">Experience<span
                                                    class="req">*</span></label>
                                            <select class="form-select" name="experience" id="experience">
                                                <option value="1 year">1 year</option>
                                                <option value="2 years">2 years</option>
                                                <option value="3 years">3 years</option>
                                                <option value="4 years">4 years</option>
                                                <option value="5 years">5 years</option>
                                                <option value="6 years">6 years</option>
                                                <option value="7 years">7 years</option>
                                                <option value="8 years">8 years</option>
                                                <option value="9 years">9 years</option>
                                                <option value="10+ years">10+ years</option>
                                            </select>

                                        </div>
                                        <div class="mb-4 col-md-6">
                                            <label for="" class="mb-2">Location<span
                                                    class="req">*</span></label>
                                            <input type="text" placeholder="location" id="location" name="location"
                                                class="form-control">
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="" class="mb-2">Description<span
                                                class="req">*</span></label>
                                        <textarea class="form-control" name="description" id="description" cols="5" rows="5"
                                            placeholder="Description"></textarea>
                                        <p></p>
                                    </div>
                                    <div class="mb-4">
                                        <label for="" class="mb-2">Benefits</label>
                                        <textarea class="form-control" name="benefits" id="benefits" cols="5" rows="5"
                                            placeholder="Benefits"></textarea>
                                    </div>
                                    <div class="mb-4">
                                        <label for="" class="mb-2">Responsibility</label>
                                        <textarea class="form-control" name="responsibility" id="responsibility" cols="5" rows="5"
                                            placeholder="Responsibility"></textarea>
                                    </div>
                                    <div class="mb-4">
                                        <label for="" class="mb-2">Qualifications</label>
                                        <textarea class="form-control" name="qualification" id="qualification" cols="5" rows="5"
                                            placeholder="Qualifications"></textarea>
                                    </div>



                                    <div class="mb-4">
                                        <label for="" class="mb-2">Keywords<span
                                                class="req">*</span></label>
                                        <input type="text" placeholder="keywords" id="keywords" name="keywords"
                                            class="form-control">
                                    </div>

                                    <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Company Details</h3>

                                    <div class="row">
                                        <div class="mb-4 col-md-6">
                                            <label for="" class="mb-2">Name<span
                                                    class="req">*</span></label>
                                            <input type="text" placeholder="Company Name" id="company_name"
                                                name="company_name" class="form-control">
                                            <p></p>
                                        </div>

                                        <div class="mb-4 col-md-6">
                                            <label for="" class="mb-2">Location</label>
                                            <input type="text" placeholder="Location" id="company_location"
                                                name="company_location" class="form-control">
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="" class="mb-2">Website</label>
                                        <input type="text" placeholder="Website" id="company_website"
                                            name="company_website" class="form-control">
                                    </div>
                                </div>
                                <div class="card-footer  p-4">
                                    <button type="submit" class="btn btn-primary">Save Job</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </section>
@endsection

@section('customJs')
    <script type="text/javascript">
        $("#postJob").submit(function(e) {
            e.preventDefault();
            $("button[type='submit']").prop('disabled', true);
            $.ajax({
                url: "{{ route('account.save.job') }}",
                type: 'post',
                dataType: 'json',
                data: $("#postJob").serializeArray(),
                success: function(response) {
                    $("button[type='submit']").prop('disabled', false);
                    if (response.status == true) {
                        $('#title').removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback')
                            .html('');
                        $('#catagory_id').removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback')
                            .html('');
                        $('#job_type_id').removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback')
                            .html('');
                        $('#vacancy').removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback')
                            .html('');
                        $('#location').removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback')
                            .html('');
                        $('#description').removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback')
                            .html('');
                        $('#company_name').removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback')
                            .html('');
                        window.location.href = "{{ route('account.my.job') }}";
                    } else {
                        var errors = response.errors;

                        if (errors.title) {
                            $("#title").addClass('is-invalid').siblings('p').addClass(
                                    'invalid-feedback')
                                .html(errors.title);
                        } else {
                            $('#catagory_id').removeClass('is-invalid').siblings('p').removeClass(
                                    'invalid-feedback')
                                .html('');
                        }


                        if (errors.catagory_id) {
                            $("#catagory_id").addClass('is-invalid').siblings('p').addClass(
                                    'invalid-feedback')
                                .html(errors.catagory_id);
                        } else {
                            $('#catagory_id').removeClass('is-invalid').siblings('p').removeClass(
                                    'invalid-feedback')
                                .html('');
                        }
                        if (errors.job_type_id) {
                            $("#job_type_id").addClass('is-invalid').siblings('p').addClass(
                                    'invalid-feedback')
                                .html(errors.job_type_id);
                        } else {
                            $('#job_type_id').removeClass('is-invalid').siblings('p').removeClass(
                                    'invalid-feedback')
                                .html('');
                        }
                        if (errors.vacancy) {
                            $("#vacancy").addClass('is-invalid').siblings('p').addClass(
                                    'invalid-feedback')
                                .html(errors.vacancy);
                        } else {
                            $('#vacancy').removeClass('is-invalid').siblings('p').removeClass(
                                    'invalid-feedback')
                                .html('');
                        }
                        if (errors.location) {
                            $("#location").addClass('is-invalid').siblings('p').addClass(
                                    'invalid-feedback')
                                .html(errors.location);
                        } else {
                            $('#location').removeClass('is-invalid').siblings('p').removeClass(
                                    'invalid-feedback')
                                .html('');
                        }
                        if (errors.description) {
                            $("#description").addClass('is-invalid').siblings('p').addClass(
                                    'invalid-feedback')
                                .html(errors.description);
                        } else {
                            $('#description').removeClass('is-invalid').siblings('p').removeClass(
                                    'invalid-feedback')
                                .html('');
                        }
                        if (errors.company_name) {
                            $("#company_name").addClass('is-invalid').siblings('p').addClass(
                                    'invalid-feedback')
                                .html(errors.company_name);
                        } else {
                            $('#company_name').removeClass('is-invalid').siblings('p').removeClass(
                                    'invalid-feedback')
                                .html('');
                        }
                    }
                }
            })
        });
    </script>
@endsection
