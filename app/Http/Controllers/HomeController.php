<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Catagory;
use App\Models\Job;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $catagories = Catagory::where('status', 1)->orderBy('name', 'ASC')->take(8)->get();

        $featuredJobs = Job::where([
            'status' => 1,
            'isFeatured' => 1
        ])->with('jobType')->orderBy('created_at', 'DESC')->take(6)->get();

        $letestJobs = Job::where('status', 1)->with('jobType')->orderBy('created_at', 'DESC')->take(6)->get();

        return view('front.home', [
            'catagories' => $catagories,
            'featuredJobs' => $featuredJobs,
            'letestJobs' => $letestJobs
        ]);
    }
}
