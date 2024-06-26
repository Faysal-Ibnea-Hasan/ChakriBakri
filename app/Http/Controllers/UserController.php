<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Session;
use Validator;
use Hash;
use Auth;

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
        return view('front.account.profile');
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

}

