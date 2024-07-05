<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Catagory;
use App\Models\Job;
use App\Models\JobType;
use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Session;
use Validator;
use Hash;
use Auth;
use File;

class UserController extends Controller
{
    /**
     * Display the user registration form.
     *
     * @return \Illuminate\View\View
     */
    public function userRegistration()
    {
        return view('front.account.reg');
    }

    /**
     * Handle the user registration process.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userRegistrationProcess(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|same:confirm_password',
            'confirm_password' => 'required',
        ]);

        // Check if the validation passes
        if ($validator->passes()) {
            // Create a new user instance and populate it with the request data
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);

            // Save the user to the database
            $user->save();

            // Flash success message to the session
            Session::flash('success', 'You have registered successfully');

            // Return a JSON response indicating success
            return response()->json([
                'status' => true,
                'message' => 'User registered successfully',
                'redirect_url' => route('home') // Add the redirect URL here
            ]);
        } else {
            // Return a JSON response indicating validation errors
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }

    /**
     * Display the user login form.
     *
     * @return \Illuminate\View\View
     */
    public function userLogin()
    {
        return view('front.account.login');
    }

    /**
     * Authenticate the user based on provided credentials.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userAuth(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Check if the validation passes
        if ($validator->passes()) {
            // Attempt to log the user in with the provided credentials
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                // Redirect to the user profile page if authentication is successful
                return redirect()->route('account.profile');
            } else {
                // Redirect back to the login page with an error message if authentication fails
                return redirect()->route('account.login')->with('error', 'Email or Password is incorrect!');
            }
        } else {
            // Redirect back to the login page with validation errors and the input email
            return redirect()->route('account.login')
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }
    }

    /**
     * Display the user's profile page.
     *
     * @return \Illuminate\View\View
     */
    public function userProfile()
    {
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();

        return view('front.account.profile', [
            'user' => $user
        ]);
    }

    /**
     * Log the user out and redirect to the login page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userLogout()
    {
        // Log the user out
        Auth::logout();

        // Redirect to the login page with a logout message
        return redirect()->route('account.login')->with('logout', 'You have been logged out!');
    }

    // Function to update the user's profile information
    public function userProfileUpdate(Request $request)
    {
        // Get the authenticated user's ID
        $id = Auth::user()->id;

        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5', // Name is required and should have a minimum length of 5 characters
            'email' => 'required|email|unique:users,email,' . $id . ',id' // Email is required, should be a valid email format, and must be unique in the users table, excluding the current user's email
        ]);

        // Check if validation passes
        if ($validator->passes()) {
            // Find the user by ID
            $user = User::find($id);

            // Update the user's profile with the request data
            $user->name = $request->name;
            $user->email = $request->email;
            $user->designation = $request->designation;
            $user->mobile = $request->mobile;
            $user->save(); // Save the updated user information

            // Flash success message to the session
            Session::flash('success', 'User profile updated');

            // Return a JSON response indicating success
            return response()->json([
                'status' => true,
            ]);
        } else {
            // Return a JSON response indicating failure with validation errors
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }


    // Function to update the user's profile picture
    public function updateProfilePic(Request $request)
    {
        // Get the authenticated user's ID
        $id = Auth::user()->id;

        // Validate the incoming request data for the image
        $validator = Validator::make($request->all(), [
            'image' => 'required|image' // Image is required and should be of image type
        ]);

        // Check if validation passes
        if ($validator->passes()) {
            // Get the image from the request
            $image = $request->image;
            // Get the original extension of the image
            $ext = $image->getClientOriginalExtension();
            // Create a new image name using the user's ID and current timestamp
            $imageName = $id . '-' . time() . '.' . $ext;
            // Move the image to the profile_pic directory
            $image->move(public_path('/profile_pic/'), $imageName);
            // Define the source path of the uploaded image
            $sourcePath = public_path('/profile_pic/' . $imageName);

            // Create a new image instance using the ImageManager
            $manager = new ImageManager(Driver::class);
            $image = $manager->read($sourcePath);

            // Crop and resize the image to 150x150 pixels
            $image->cover(150, 150);
            // Save the cropped and resized image as a PNG in the thumb directory
            $image->toPng()->save(public_path('/profile_pic/thumb/' . $imageName));

            // Delete the old profile picture and its thumbnail if they exist
            File::delete(public_path('/profile_pic/' . Auth::user()->image));
            File::delete(public_path('/profile_pic/thumb/' . Auth::user()->image));

            // Update the user's profile picture in the database
            User::where('id', $id)->update(['image' => $imageName]);

            // Flash success message to the session
            Session::flash('success', 'Profile picture updated successfully!');

            // Return a JSON response indicating success
            return response()->json([
                'status' => true,
            ]);
        } else {
            // Return a JSON response indicating failure with validation errors
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    /**
     * Display the create job form with categories and job types.
     *
     * @return \Illuminate\View\View
     */
    public function createJob()
    {
        // Retrieve active categories sorted by name in ascending order
        $catagories = Catagory::orderBy('name', 'ASC')->where('status', 1)->get();

        // Retrieve active job types sorted by name in ascending order
        $jobTypes = JobType::orderBy('name', 'ASC')->where('status', 1)->get();

        // Return the view with categories and job types
        return view('front.job_s.create_job', [
            'catagories' => $catagories,
            'jobTypes' => $jobTypes
        ]);
    }

    /**
     * Save a new job post to the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveJob(Request $request)
    {
        // Define validation rules for job creation
        $rules = [
            'title' => 'required',
            'catagory_id' => 'required',
            'job_type_id' => 'required',
            'vacancy' => 'required|integer',
            'location' => 'required',
            'description' => 'required',
            'company_name' => 'required',
        ];

        // Validate the request data against the rules
        $validator = Validator::make($request->all(), $rules);

        // Check if the validation passes
        if ($validator->passes()) {
            // Create a new job instance and populate it with request data
            $job = new Job();
            $job->title = $request->title;
            $job->catagory_id = $request->catagory_id;
            $job->job_type_id = $request->job_type_id;
            $job->user_id = Auth::user()->id;
            $job->vacancy = $request->vacancy;
            $job->salary = $request->salary;
            $job->location = $request->location;
            $job->description = $request->description;
            $job->benefits = $request->benefits;
            $job->responsibility = $request->responsibility;
            $job->qualification = $request->qualification;
            $job->keywords = $request->keywords;
            $job->experience = $request->experience;
            $job->company_name = $request->company_name;
            $job->company_location = $request->company_location;
            $job->company_website = $request->company_website;

            // Save the job to the database
            $job->save();

            // Flash success message to the session
            Session::flash('success', 'Job added successfully!');

            // Return a JSON response indicating success
            return response()->json([
                'status' => true,
            ]);
        } else {
            // Return a JSON response indicating validation errors
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    /**
     * Display the logged-in user's job posts.
     *
     * @return \Illuminate\View\View
     */
    public function myJob()
    {
        // Retrieve the logged-in user's job posts with associated job types, paginated by 5
        $jobs = Job::where('user_id', Auth::user()->id)->with('jobType')->paginate(5);

        // Return the view with the user's job posts
        return view('front.job_s.my_job', [
            'jobs' => $jobs
        ]);
    }

    public function editJob(Request $request, $id){
        //dd($id);
        // Retrieve active categories sorted by name in ascending order
        $catagories = Catagory::orderBy('name', 'ASC')->where('status', 1)->get();

        // Retrieve active job types sorted by name in ascending order
        $jobTypes = JobType::orderBy('name', 'ASC')->where('status', 1)->get();

        $jobs = Job::where([
            'user_id'=> Auth::user()->id,
            'id' => $id,
        ])->first();
        if($jobs==null){
            abort(404);
        }

        return view('front.job_s.edit_job',[
            'catagories' => $catagories,
            'jobTypes' => $jobTypes,
            'jobs'=>$jobs
        ]);
    }

    public function updateJob(Request $request,$id)
    {
        // Define validation rules for job creation
        $rules = [
            'title' => 'required',
            'catagory_id' => 'required',
            'job_type_id' => 'required',
            'vacancy' => 'required|integer',
            'location' => 'required',
            'description' => 'required',
            'company_name' => 'required',
        ];

        // Validate the request data against the rules
        $validator = Validator::make($request->all(), $rules);

        // Check if the validation passes
        if ($validator->passes()) {
            // Create a new job instance and populate it with request data
            $job = Job::find($id);
            $job->title = $request->title;
            $job->catagory_id = $request->catagory_id;
            $job->job_type_id = $request->job_type_id;
            $job->user_id = Auth::user()->id;
            $job->vacancy = $request->vacancy;
            $job->salary = $request->salary;
            $job->location = $request->location;
            $job->description = $request->description;
            $job->benefits = $request->benefits;
            $job->responsibility = $request->responsibility;
            $job->qualification = $request->qualification;
            $job->keywords = $request->keywords;
            $job->experience = $request->experience;
            $job->company_name = $request->company_name;
            $job->company_location = $request->company_location;
            $job->company_website = $request->company_website;

            // Save the job to the database
            $job->save();

            // Flash success message to the session
            Session::flash('success', 'Job updated successfully!');

            // Return a JSON response indicating success
            return response()->json([
                'status' => true,
            ]);
        } else {
            // Return a JSON response indicating validation errors
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
}
