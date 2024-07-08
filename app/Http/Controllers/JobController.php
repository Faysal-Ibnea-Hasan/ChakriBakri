<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Catagory;
use App\Models\Job;
use App\Models\JobType;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(){
        // Retrieve the active categories sorted by name in ascending order
        $catagories = Catagory::where('status', 1)->orderBy('name', 'ASC')->get();
        // Retrieve the active jobTypes sorted by name in ascending order
        $jobTypes = JobType::where('status', 1)->orderBy('name', 'ASC')->get();
        // Retrieve the  latest jobs with their job types, sorted by creation date in descending order
        $letestJobs = Job::where('status', 1)->with('jobType')->orderBy('created_at', 'DESC')->paginate(9);
        return view('front.job_s.all_job',[
            'catagories' => $catagories,
            'jobTypes' => $jobTypes,
            'letestJobs' => $letestJobs
        ]);
    }
}
