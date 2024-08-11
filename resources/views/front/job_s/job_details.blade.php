@extends('front.layouts.app')
@section('main')
    <section class="section-4 bg-2">
        <div class="container pt-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('all.jobs') }}"><i class="fa fa-arrow-left"
                                        aria-hidden="true"></i>
                                    &nbsp;Back to Jobs</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="container job_details_area">
            <div class="row pb-5">
                <div class="col-md-8">
                    @if (Session::has('success'))
                        <!-- Display success message if it exists in the session -->
                        <div class="alert alert-success">
                            <p>{{ Session::get('success') }}</p>
                        </div>
                    @elseif (Session::has('error'))
                        <!-- Display error message if it exists in the session -->
                        <div class="alert alert-danger">
                            <p>{{ Session::get('error') }}</p>
                        </div>
                    @endif
                    <div class="card shadow border-0">
                        <div class="job_details_header">
                            <div class="single_jobs white-bg d-flex justify-content-between">
                                <div class="jobs_left d-flex align-items-center">

                                    <div class="jobs_conetent">
                                        <a href="#">
                                            <h4>{{ $jobs->title }}</h4>
                                        </a>
                                        <div class="links_locat d-flex align-items-center">
                                            <div class="location">
                                                <p> <i class="fa fa-map-marker"></i> {{ $jobs->location }}</p>
                                            </div>
                                            <div class="location">
                                                <p> <i class="fa fa-clock-o"></i> {{ $jobs->jobType->name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="jobs_right">
                                    <div class="apply_now">
                                        <a class="heart_mark" href="#"> <i class="fa fa-heart-o"
                                                aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="descript_wrap white-bg">
                            <div class="single_wrap">
                                <h4>Job description</h4>
                                <p>{!! nl2br($jobs->description) !!}</p>

                            </div>
                            @if (!empty($jobs->responsibility))
                                <div class="single_wrap">
                                    <h4>Responsibility</h4>
                                    <p>{!! nl2br($jobs->responsibility) !!}</p>
                                </div>
                            @endif
                            @if (!empty($jobs->qualification))
                                <div class="single_wrap">
                                    <h4>Qualifications</h4>
                                    <p>{!! nl2br($jobs->qualification) !!}</p>
                                </div>
                            @endif
                            @if (!empty($jobs->benefits))
                                <div class="single_wrap">
                                    <h4>Benefits</h4>
                                    <p>{!! nl2br($jobs->benefits) !!}</p>
                                </div>
                            @endif

                            <div class="border-bottom"></div>
                            <div class="pt-3 text-end">
                                <a href="#" class="btn btn-secondary">Save</a>
                                @if (Auth::check())
                                    <a href="#" onclick="apply({{ $jobs->id }})" class="btn btn-primary">Apply</a>
                                @else
                                    <a href="javascript:void(0);" class="btn btn-primary disabled">Login To Apply</a>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow border-0">
                        <div class="job_sumary">
                            <div class="summery_header pb-1 pt-4">
                                <h3>Job Summery</h3>
                            </div>
                            <div class="job_content pt-3">
                                <ul>
                                    <li>Published on:
                                        <span>{{ \Carbon\Carbon::parse($jobs->created_at)->format('d M, Y') }}</span>
                                    </li>
                                    <li>Vacancy: <span>{{ $jobs->vacancy }}</span></li>
                                    @if (!empty($jobs->salary))
                                        <li>Salary: <span>{{ $jobs->salary }}</span></li>
                                    @endif
                                    <li>Location: <span>{{ $jobs->location }}</span></li>
                                    <li>Job Nature: <span> {{ $jobs->jobType->name }}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow border-0 my-4">
                        <div class="job_sumary">
                            <div class="summery_header pb-1 pt-4">
                                <h3>Company Details</h3>
                            </div>
                            <div class="job_content pt-3">
                                <ul>
                                    <li>Name: <span>{{ $jobs->company_name }}</span></li>
                                    @if (!empty($jobs->company_location))
                                        <li>Locaion: <span>{{ $jobs->company_location }}</span></li>
                                    @endif

                                    {{-- Explanation:
                                         strpos($jobs->company_website, 'http://') === 0 || strpos($jobs->company_website, 'https://') === 0: This checks if the company_website string starts with http:// or https://.
                                        ? $jobs->company_website : 'http://' . $jobs->company_website: If the URL already includes a protocol, it will use the original URL; otherwise, it will prepend http://.
                                        Example:
                                        If {{ $jobs->company_website }} is www.Ezpay.com, the href will be http://www.Ezpay.com.
                                        If {{ $jobs->company_website }} is https://www.Ezpay.com, the href will be https://www.Ezpay.com. --}}
                                    @if (!empty($jobs->company_website))
                                        <li>Webite: <span><a target=”_blank”
                                                    href="{{ strpos($jobs->company_website, 'http://') === 0 || strpos($jobs->company_website, 'https://') === 0 ? $jobs->company_website : 'http://' . $jobs->company_website }}">{{ $jobs->company_website }}</a></span>
                                        </li>
                                    @endif

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('customJs')
    <script type="text/javascript">
        function apply(id) {
            if (confirm('Are you sure you want to apply this job?')) {
                $.ajax({
                    url: "{{ route('all.jobs.apply') }}",
                    type: 'post',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        window.location.href = "{{ url()->current() }}";
                    }
                });
            }
        }
    </script>
@endsection
