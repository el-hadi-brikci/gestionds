<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use constGuards;
use constDefaults;
use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class AdminController extends Controller
{
    public function loginHandler(Request $request)
    {
        $fieldType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? "email" : "username";
        if ($fieldType == "email") {
            $request->validate([
                'login_id' => 'required|email|exists:admins,email',
                'password' => 'required|min:5|max:45'
            ], [
                'login_id.required' => 'Email or Username is required',
                'login_id.email' => 'Invalid email address',
                'login_id.exists' => 'Email does not exist in the system',
                'password.required' => 'Password is required',
            ]);
        } else {
            $request->validate([
                'login_id' => 'required|exists:admins,username',
                'password' => 'required|min:5|max:45'
            ], [
                'login_id.required' => 'Email or Username is required',
                'login_id.exists' => 'Username is not exists in system',
                'password.required' => 'Password is required'
            ]);
        }
        $creds = array(
            $fieldType => $request->login_id,
            'password' => $request->password
        );
        if (Auth::guard('admin')->attempt($creds)) {
            return redirect()->route('adminhome');
        } else {
            session()->flash('fail', 'Incorrect credentials');
            return redirect()->route('adminlogin');
        }
    }
    public function logoutHandler(Request $request)
    {
        Auth::guard('admin')->logout();
        session()->flash('fail', 'you are logged out! ');
        return redirect()->route('adminlogin');
    }

    public function sendPasswordResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email'
        ], [
            'email.required' => 'The :attribute is required',
            'email.email' => 'invalid email address',
            'email.exists' => 'The :attribute is not in the system'
        ]);
        $admin = Admin::where('email', $request->email)->first();
        //Generate token
        $token = base64_encode(Str::random(64));
        //Check if there is an existing reset password token
        $oldToken = DB::table('password_reset_tokens')
            ->where(['email' => $request->email, 'guard' => constGuards::ADMIN])->first();

        if ($oldToken) {
            //Update token
            DB::table('password_reset_tokens')
                ->where(['email' => $request->email, 'guard' => constGuards::ADMIN])
                ->update([
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]);
        } else {
            //Add new token
            DB::table('password_reset_tokens')->insert([
                'email' => $request->email,
                'guard' => constGuards::ADMIN,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);
        }
        $actionLink = route('adminreset-password', ['token' => $token, 'email', $request->email]);

        $data = array(
            'actionLink' => $actionLink,
            'admin' => $admin,
        );


        $mail_body = view('email-templates.admin-forgot-email-templates', $data)->render();
        $mail_config = array(
            'mail_from_email' => env('EMAIL_FROM_ADDRESS'),
            'mail_from_name' => env('EMAIL_FROM_NAME'),
            'mail_recipient_email' => $admin->email,
            'mail_recipient_name' => $admin->name,
            'mail_subject' => 'reset password',
            'mail_body' => $mail_body
        );

        if (sendEmail($mail_config)) {
            session()->flash('success', 'We have e-mailed your password reset link.');
            return redirect()->route('adminforgot-password');
        } else {
            session()->flash('failed', 'Somthing went Wrong !');
            return redirect()->route('adminforgot-password');
        }
    }

    public function resetPassword(Request $request, $token = null)
    {
        $check_token = DB::table('password_reset_tokens')
            ->where(['token' => $token, 'guard' => constGuards::ADMIN])
            ->first();

        if ($check_token) {
            //Check if token is not expired
            $diffMins = Carbon::createFromFormat('Y-m-d H:i:s', $check_token->created_at)->diffInMinutes(Carbon::now());

            if ($diffMins > constDefaults::tokenExpiredMinutes) {
                //If token expired
                session()->flash('fail', 'Token expired, request another reset password link.');
                return redirect()->route('adminforget-password', ['token' => $token]);
            } else {
                return view('back.pages.admin.auth.reset-password')->with(['token' => $token]);
            }

        } else {
            session()->flash('fail', 'Invalid token!, request another reset password link');
            return redirect()->route('adminforgot-password', ['token' => $token]);
        }
    }
    public function resetPasswordHandler(Request $request)
    {
        // Log the request data
        \Log::info('Request data:', $request->all());
    
        $request->validate([
            'new_password' => 'required|min:5|max:45|required_with:new_password_confirmation|same:new_password_confirmation',
            'new_password_confirmation' => 'required'
        ]);
    
        // If validation fails, Laravel will automatically redirect the user back to the form.
        // So, if the code execution reaches this point, it means validation passed.
    
        $token = DB::table('password_reset_tokens')
            ->where(['token' => $request->token, 'guard' => constGuards::ADMIN])
            ->first();
        $admin = Admin::where('email', $token->email)->first();
        Admin::where('email', $admin->email)->update([
            'password' => Hash::make($request->new_password)
        ]);
        DB::table('password_reset_tokens')->where([
            'email' => $admin->email,
            'token' => $request->token,
            'guard' => constGuards::ADMIN
        ])->delete();
    
        $data = array(
            'admin' => $admin,
            'new_password' => $request->new_password
        );
        $mail_body = view('email-templates.admin-reset-email-template', $data)->render();
        $mailConfig = array(
            'mail_from_email' => env('EMAIL_FROM_ADDRESS'),
            'mail_from_name' => env('EMAIL_FROM_NAME'),
            'mail_recipient_email' => $admin->email,
            'mail_recipient_name' => $admin->name,
            'mail_subject' => 'Password changed',
            'mail_body' => $mail_body   
        );
    
        sendEmail($mailConfig);
        return redirect()->route('adminlogin')->with('success', 'Done!, Your password has been changed. Use new password to login into system. ');
    }
    public function profileView (Request $request)
    {
        $admin = null;
        if( Auth ::guard('admin')->check() ){
            $admin = Admin::findOrFail (auth()->id());
        }
        return view('back.pages.admin.profile', compact('admin'));
    }
}