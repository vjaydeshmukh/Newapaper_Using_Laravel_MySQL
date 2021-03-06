<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    
    use SendsPasswordResetEmails;


    public function showLinkRequestForm(){
        return view('backend.auth.passwords.email');
    }

    public function broker()
    {
        return Password::broker('admins');
    }
}
