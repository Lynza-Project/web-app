<?php

namespace App\Helpers;

class UserHelper
{

    /**
     * Check if the user is an admin or superadmin
     * @return bool
     */
    public static function isAdministrator(): bool
    {
        return in_array(auth()->user()->role, ['admin', 'super-admin']);
    }

    /**
     * Check if the user is a superadmin
     * @return bool
     */
    public static function isSuperAdministrator(): bool
    {
        return auth()->user()->role === 'super-admin';
    }
}
