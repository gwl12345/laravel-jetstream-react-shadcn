<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Fortify\Features;
use Laravel\Jetstream\Http\Controllers\Inertia\Concerns\ConfirmsTwoFactorAuthentication;
use Inertia\Inertia;

class TwoFactorController extends Controller
{
    use ConfirmsTwoFactorAuthentication;

    /**
     * Show the two-factor authentication settings page.
     */
    public function show(Request $request)
    {
        $this->validateTwoFactorAuthenticationState($request);

        return Inertia::render('Profile/TwoFactorAuthenticationForm', [
            'requiresConfirmation' => Features::optionEnabled(Features::twoFactorAuthentication(), 'confirm'),
        ]);
    }
}
