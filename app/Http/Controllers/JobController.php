<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Catagory;
use App\Models\Job;
use App\Models\JobType;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use App\Mail\JobNotifiactionEmail;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Mail;

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
        $jobs = $jobs->with('jobType');
        if ($request->sort == 'oldest') {
            $jobs = $jobs->orderBy('created_at', 'ASC');
        } else if ($request->sort == 'latest') {
            $jobs = $jobs->orderBy('created_at', 'DESC');
        }
        $jobs = $jobs->paginate(9);

        //$latestJobs = $jobs->orderBy('created_at', 'DESC');
        //dd($letestJobs);
        return view('front.job_s.all_job', [
            'catagories' => $catagories,
            'jobTypes' => $jobTypes,
            'jobs' => $jobs,
            'jobTypeArray' => $jobTypeArray
        ]);
    }

    public function jobDetails($id)
    {
        $jobs = Job::where(['id' => $id, 'status' => 1])->with(['jobType', 'catagory'])->first();
        //dd($jobs);
        if ($jobs == null) {
            abort(404);
        }
        return view('front.job_s.job_details', [
            'jobs' => $jobs
        ]);
    }

    public function applyJob(Request $request)
    {
        $id = $request->id;
        $job = Job::where('id', $id)->first();
        if ($job == null) {
            session()->flash('error', 'This record is not found');
            return response()->json([
                'status' => false,
                'message' => 'This record is not found'
            ], 404);
        }
        //Check if job applied twice
        $job_application_count = JobApplication::where([
            'user_id' => Auth::user()->id,
            'job_id' => $id
        ])->count();
        if ($job_application_count > 0) {
            session()->flash('error', 'You have already applied on this job!');
            return response()->json([
                'status' => false,
                'message' => 'You have already applied on this job!'
            ]);
        }
        //Check own job
        $employer_id = $job->user_id;
        if ($employer_id == Auth::user()->id) {
            session()->flash('error', 'You are not allowed to apply own job!');
            return response()->json([
                'status' => false,
                'message' => 'You are not allowed to apply own job!'
            ]);
        }

        $job_application = new JobApplication();
        $job_application->user_id = Auth::user()->id;
        $job_application->job_id = $id;
        $job_application->employer_id = $employer_id;
        $job_application->applied_date = now();
        $job_application->save();

        //Send Mail
        $employer = User::where('id', $employer_id)->first();
        $mailData = [
            'employer' => $employer,
            'user' => Auth::user(),
            'job' => $job,
        ];
        Mail::to($employer->email)->send(new JobNotifiactionEmail($mailData));

        session()->flash('success', 'You have applied successfully.');
        return response()->json([
            'status' => true,
            'message' => 'You have applied successfully.'
        ]);

    }
}
