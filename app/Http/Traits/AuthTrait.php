<?php

namespace App\Http\Traits;

use App\Providers\RouteServiceProvider;

trait AuthTrait
{
    /**
     * Determine the guard based on the request type.
     *
     * @param  \Illuminate\Http\Request $request
     * @return string
     */
    public function checkGuard($role)
    {
        switch ($role) {
            case 'student':
                $guardName = 'student';
                break;
            case 'parent':
                $guardName = 'parent';
                break;
            case 'teacher':
                $guardName = 'teacher';
                break;
            default:
                $guardName = 'web';
        }
        return $guardName;
    }

    /**
     * Redirect the user to the appropriate route based on the role.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function roleRedirect($guard)
    {
        // Checking the guard and redirecting accordingly
        switch ($guard) {

            case 'student':
                return redirect()->intended(RouteServiceProvider::STUDENT);
            case 'parent':
                return redirect()->intended(RouteServiceProvider::PARENT);
            case 'teacher':
                return redirect()->intended(RouteServiceProvider::TEACHER);
            case 'web':
                return redirect()->intended(RouteServiceProvider::HOME);
            default:
                return redirect()->intended(RouteServiceProvider::HOME);
        }
    }
}
