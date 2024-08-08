<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Catagory;
use App\Models\Job;
use App\Models\JobType;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve the active categories sorted by name in ascending order
        $catagories = Catagory::where('status', 1)->orderBy('name', 'ASC')->get();
        // Retrieve the active jobTypes sorted by name in ascending order
        $jobTypes = JobType::where('status', 1)->orderBy('name', 'ASC')->get();
        // Retrieve the  latest jobs with their job types, sorted by creation date in descending order lol
        $jobs = Job::where('status', 1);
        //Search using keywords
        if (!empty($request->keywords)) {
            $filteredJobs = $jobs->where(function ($query) use ($request) {
                $query->orWhere('title', 'like', '%' . $request->keywords . '%');
                $query->orWhere('keywords', 'like', '%' . $request->keywords . '%');
            });
        }
        //Search using location
        if (!empty($request->location)) {
            $filteredJobs = $jobs->where('location', $request->location);
        }
        //Search using catagory
        if (!empty($request->catagory)) {
            $filteredJobs = $jobs->where('catagory_id', $request->catagory);
        }
        //Search using job type
        $jobTypeArray = [];
        if (!empty($request->jobType)) {
            //1,2,3
            $jobTypeArray = explode(',', $request->jobType);
            $filteredJobs = $jobs->whereIn('job_type_id', $jobTypeArray);
        }
        //Search using experience
        if (!empty($request->experience)) {
            $filteredJobs = $jobs->where('experience', $request->experience);
        }
        $letestJobs = $jobs->with('jobType')->orderBy('created_at', 'DESC')->paginate(9);
        //dd($letestJobs);
        return view('front.job_s.all_job', [
            'catagories' => $catagories,
            'jobTypes' => $jobTypes,
            'letestJobs' => $letestJobs,
            'jobTypeArray' => $jobTypeArray
        ]);
    }
}
