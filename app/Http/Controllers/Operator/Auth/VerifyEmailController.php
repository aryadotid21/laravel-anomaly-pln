<?php

namespace App\Http\Controllers\Operator\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use App\Http\Requests\Operator\Auth\EmailVerificationRequest;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated operator's email address as verified.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        if ($request->user('operator')->hasVerifiedEmail()) {
            return redirect()->intended(route('operator.dashboard').'?verified=1');
        }

        if ($request->user('operator')->markEmailAsVerified()) {
            event(new Verified($request->user('operator')));
        }

        return redirect()->intended(route('operator.dashboard').'?verified=1');
    }
}
