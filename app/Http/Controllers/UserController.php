<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;






class UserController extends Controller
{
    public function UserStore(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|max:15',
            'password' => 'required|min:6|confirmed',
        ]);

        // Create new user and save in database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 2
        ]);

        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }

    public function EmployeeStore(Request $request){

        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|digits:10|unique:users,mobile',
            'employee_id' => 'required|string|max:15',
            'password' => 'required|min:6|confirmed',
        ]);

        // Create new user and save in database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'designation' => $request->designation,
            'department' => $request->department,
            'mobile' => $request->mobile,
            'employee_id' => $request->employee_id,
            'working_place' => $request->working_place,
            'gender' => $request->gender,
            'password' => Hash::make($request->password),
            'role' => 3
        ]);

        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }

    public function UserCheck(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        
        $loginField = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';

        // Attempt to authenticate
        if (Auth::attempt([$loginField => $request->email, 'password' => $request->password])) {
            return redirect()->route('order_tracking.create');    
        }
        
        return back()->withErrors(['email' => 'Invalid email or password'])->withInput();
    }

    public function logout(){
        Auth::logout();

        return redirect()->route('login');
    }

    public function ChangePassword(){
        $user = Auth::user();
        return view('change_password', compact('user'));
    }

    public function UpdatePassword(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Old password is incorrect']);
        }

        $user->name = $request->name;
        $user->password = Hash::make($request->new_password);
        $user->save();

        Auth::logout();

        return redirect()->route('login')->with('success', 'Password updated successfully!');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Check if user exists
        $user = DB::table('users')->where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Email address not found.']);
        }


        return back()->with('success', 'Password reset link sent!');
        
        
    }

    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function showResetForm(Request $request, $token)
    {
        $email = $request->query('email');
        
        // Verify token and email match
        $tokenData = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('token', $token)
            ->first();

        if (!$tokenData) {
            return redirect('/forgot-password')->withErrors([
                'email' => 'Invalid or expired password reset link.'
            ]);
        }

        // Optional: check expiry (e.g. 60 minutes)
        if (Carbon::parse($tokenData->created_at)->addMinutes(60)->isPast()) {
            return redirect('/forgot-password')->withErrors([
                'email' => 'Reset link expired. Please request a new one.'
            ]);
        }

        return view('auth.reset-password', ['token' => $token, 'email' => $email]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Validate token and email
        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$record) {
            return back()->withErrors(['email' => 'Invalid token or email.']);
        }

        // Update user password
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->setRememberToken(Str::random(60));
        $user->save();

        // Delete token after reset
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('status', 'Password has been reset successfully!');
    }

 
}
