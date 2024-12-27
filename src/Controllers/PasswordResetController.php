<?php

namespace EasyTodo\Controllers;

use EasyTodo\Models\User;

class PasswordResetController
{
    // Display the password reset request form.
    public function requestResetForm()
    {
        require "../src/Views/password/request.php";
    }

    // Handle the password reset request from the user.
    public function handleRequestReset($data)
    {
        session_start();
        if (
            empty($data["email"]) ||
            !filter_var($data["email"], FILTER_VALIDATE_EMAIL)
        ) {
            // Invalid email address, set error message
            $_SESSION['error'] = 'Invalid email address.';
            header("Location: /login");
            exit();
        }

        $user = new User();
        $userData = $user->findUserByEmail($data["email"]);

        // Check if the user exists
        if ($userData) {
            $token = bin2hex(random_bytes(50));

            // Save the reset token associated with the user's email
            if ($user->savePasswordResetToken($data["email"], $token)) {
                // Create the reset link
                $resetLink = "http://localhost:8080/password/reset?token=$token";
                $subject = "Password Reset Request";
                $message = "Click the link to reset your password: $resetLink";

                // Send the reset link via email
                if (!mail($data["email"], $subject, $message)) {
                    // Log error or notify admin
                    error_log("Failed to send reset email to " . $data["email"]);
                    $_SESSION['error'] = 'Failed to send reset email.';
                    header("Location: /login");
                    exit();
                }

                $_SESSION['success'] = 'Reset link sent to your email.';
                header("Location: /login");
                exit();
            } else {
                // Failed to save token, set error message
                $_SESSION['error'] = 'Failed to save reset token.';
                header("Location: /login");
                exit();
            }
        } else {
            // User does not exist, set error message
            $_SESSION['error'] = 'User not found.';
            header("Location: /login");
            exit();
        }
    }

    // Display the password reset form.
    public function resetPasswordForm($token)
    {
        session_start();
        if (empty($token)) {
            // No token provided, set error message
            $_SESSION['error'] = 'No token provided.';
            header("Location: /login");
            exit();
        }

        $user = new User();
        $userData = $user->findUserByResetToken($token);

        // Validate the token
        if ($userData) {
            require "../src/Views/password/reset.php";
        } else {
            // Invalid token, set error message
            $_SESSION['error'] = 'Invalid reset token.';
            header("Location: /login");
            exit();
        }
    }

    // Handle the password reset submission.
    public function handleResetPassword($data)
    {
        session_start();
        if (
            empty($data["token"]) ||
            empty($data["password"]) ||
            strlen($data["password"]) < 6
        ) {
            // Invalid input, set error message
            $_SESSION['error'] = 'Invalid input data.';
            header("Location: /login");
            exit();
        }

        $user = new User();
        $userData = $user->findUserByResetToken($data["token"]);

        // Check if the token is valid
        if ($userData) {
            // Update the user's password
            if (
                $user->updatePassword(
                    $userData["id"],
                    password_hash($data["password"], PASSWORD_DEFAULT)
                )
            ) {
                // Optionally, you can invalidate the reset token here
                $user->invalidateResetToken($data["token"]);

                $_SESSION['success'] = 'Password reset successfully.';
                header("Location: /login");
                exit();
            } else {
                // Failed to update password, set error message
                $_SESSION['error'] = 'Failed to update password.';
                header("Location: /login");
                exit();
            }
        } else {
            // Invalid token, set error message
            $_SESSION['error'] = 'Invalid reset token.';
            header("Location: /login");
            exit();
        }
    }
}