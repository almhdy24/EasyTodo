<?php
namespace EasyTodo\Controllers;

use EasyTodo\Models\User;

class PasswordResetController extends BaseController {
    public function requestReset($email) {
        $user = User::findByEmail($email);
        if ($user) {
            $user->sendPasswordReset($email);
        }
        // Inform the user to check their email
    }

    public function reset($token, $newPassword) {
        $user = User::findByToken($token);
        if ($user) {
            $user->resetPassword($token, $newPassword);
        }
        // Inform the user that their password has been reset
    }
}