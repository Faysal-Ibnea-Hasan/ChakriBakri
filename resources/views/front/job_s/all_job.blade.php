@extends('front.layouts.app')
@section('main')
    <section class="section-3 py-5 bg-2 ">
        <div class="container">
            <div class="row">
                <div class="col-6 col-md-10 ">
                    <h2>Find Jobs</h2>
                </div>
                <div class="col-6 col-md-2">
                    <div class="align-end">
                        <select name="sort" id="sort" class="form-control">
                            <option value="latest"{{ Request::get('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                            <option value="oldest"{{ Request::get('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row pt-5">
                <div class="col-md-4 col-lg-3 sidebar mb-4">
                    <form action="" method="POST" name="searchForm" id="searchForm">
                        <div class="card border-0 shadow p-4">
                            <div class="mb-4">
                                <h2>Keywords</h2>
                                <input value="{{ Request::get('keywords') }}" type="text" name="keywords" id="keywords"
                                    placeholder="Keywords" class="form-control">
                            </div>

                            <div class="mb-4">
                                <h2>Location</h2>
                                <input value="{{ Request::get('location') }}" type="text" name="location" id="location"
                                    placeholder="Location" class="form-control">
                            </div>

                            <div class="mb-4">
                                <h2>Category</h2>
                                <select name="catagory" id="catagory" class="form-control">
                                    <option value="">Select a Category</option>
                                    @if ($catagories->isNotEmpty())
                                        @foreach ($catagories as $catagory)
                                            <option {{ Request::get('catagory') == $catagory->id ? 'selected' : '' }}
                                                value="{{ $catagory->id }}">{{ $catagory->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="mb-4">
                                <h2>Job Type</h2>
                                @if ($jobTypes->isNotEmpty())
                                    @foreach ($jobTypes as $jobType)
                                        <div class="form-check mb-2">
                                            <input {{ in_array($jobType->id, $jobTypeArray) ? 'checked' : '' }}
                                                class="form-check-input " name="job_type" type="checkbox"
                                                value="{{ $jobType->id }}" id="job-type-{{ $jobType->name }}">
                                            <label class="form-check-label "
                                                for="job-type-{{ $jobType->name }}">{{ $jobType->name }}</label>
                                        </div>
                                    @endforeach
                                @endif


                            </div>

                            <div class="mb-4">
                                <h2>Experience</h2>
                                <select name="experience" id="experience" class="form-control">
                                    <option value="">Select Experience</option>
                                    <option value="1"{{ Request::get('experience') == 1 ? 'selected' : '' }}>1 Year
                                    </option>
                                    <option value="2"{{ Request::get('experience') == 2 ? 'selected' : '' }}>2 Years
                                    </option>
                                    <option value="3"{{ Request::get('experience') == 3 ? 'selected' : '' }}>3 Years
                                    </option>
                                    <option value="4"{{ Request::get('experience') == 4 ? 'selected' : '' }}>4 Years
                                    </option>
                                    <option value="5"{{ Request::get('experience') == 5 ? 'selected' : '' }}>5 Years
                                    </option>
                                    <option value="6"{{ Request::get('experience') == 6 ? 'selected' : '' }}>6 Years
                                    </option>
                                    <option value="7"{{ Request::get('experience') == 7 ? 'selected' : '' }}>7 Years
                                    </option>
                                    <option value="8"{{ Request::get('experience') == 8 ? 'selected' : '' }}>8 Years
                                    </option>
                                    <option value="9"{{ Request::get('experience') == 9 ? 'selected' : '' }}>9 Years
                                    </option>
                                    <option value="10"{{ Request::get('experience') == 10 ? 'selected' : '' }}>10 Years
                                    </option>
                                    <option value="10+"{{ Request::get('experience') == '10+' ? 'selected' : '' }}>10+
                                        Years</option>
                                </select>
                            </div>
                            <button class="btn btn-primary" type="submit">Search</button>
                            <a class="btn btn-secondary mt-3" href="{{route('all.jobs')}}">Reset Filters</a>
                        </div>
                    </form>
                </div>
                <div class="col-md-8 col-lg-9 ">
                    <div class="job_listing_area">
                        <div class="job_lists">
                            <div class="row">
                                @if ($jobs->isNotEmpty())
                                    @foreach ($jobs as $letestJob)
                                        <div class="col-md-4">
                                            <div class="card border-0 p-3 shadow mb-4">
                                                <div class="card-body">
                                                    <h3 class="border-0 fs-5 pb-2 mb-0">{{ $letestJob->title }}</h3>
                                                    <p>{{ Str::words($letestJob->description, $words = 10, '...') }}</p>
                                                    <div class="bg-light p-3 border">
                                                        <p class="mb-0">
                                                            <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                                            <span class="ps-1">{{ $letestJob->location }}</span>
                                                        </p>
                                                        <p class="mb-0">
                                                            <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                                            <span class="ps-1">{{ $letestJob->jobType->name }}</span>
                                                        </p>
                                                        @if (!is_null($letestJob->salary))
                                                            <p class="mb-0">
                                                                <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                                                <span class="ps-1">{{ $letestJob->salary }}</span>
                                                            </p>
                                                        @else
                                                            <p class="mb-0">
                                                                <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                                                <span class="ps-1">Nagotiable</span>
                                                            </p>
                                                        @endif

                                                    </div>

                                                    <div class="d-grid mt-3">
                                                        <a href="job-detail.html" class="btn btn-primary btn-lg">Details</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif



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
        $("#searchForm").submit(function(e) {
            e.preventDefault();
            var url = "{{ route('all.jobs') }}?"
            var keywords = $('#keywords').val();
            var location = $('#location').val();
            var catagory = $('#catagory').val();
            var sort = $('#sort').val();
            var experience = $('#experience').val();
            var jobType = $("input:checkbox[name='job_type']:checked").map(function() {
                return $(this).val();
            }).get();

            if (keywords != "") {
                url += '&keywords=' + keywords;
            }
            if (location != "") {
                url += '&location=' + location;
            }
            if (catagory != "") {
                url += '&catagory=' + catagory;
                console.log(catagory);
            }
            if (experience != "") {
                url += '&experience=' + experience;
            }
            if (jobType.length > 0) {
                url += '&jobType=' + jobType;
            }
            url += '&sort=' + sort;
            window.location.href = url;
        });
        $("#sort").change(function() {
            $("#searchForm").submit();
        })
    </script>
@endsection
