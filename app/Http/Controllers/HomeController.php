<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Catagory;
use App\Models\Job;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page with categories, featured jobs, and latest jobs.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Retrieve the first 8 active categories sorted by name in ascending order
        $catagories = Catagory::where('status', 1)->orderBy('name', 'ASC')->take(8)->get();

        // Retrieve the first 6 featured jobs with their job types, sorted by creation date in descending order
        $featuredJobs = Job::where([
            'status' => 1,
            'isFeatured' => 1
        ])->with('jobType')->orderBy('created_at', 'DESC')->take(6)->get();

        // Retrieve the first 6 latest jobs with their job types, sorted by creation date in descending order
        $letestJobs = Job::where('status', 1)->with('jobType')->orderBy('created_at', 'DESC')->take(6)->get();

        // Return the home view with the retrieved categories, featured jobs, and latest jobs
        return view('front.home', [
            'catagories' => $catagories,
            'featuredJobs' => $featuredJobs,
            'letestJobs' => $letestJobs
        ]);
    }

}
