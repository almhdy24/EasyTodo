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
    if (
      empty($data["email"]) ||
      !filter_var($data["email"], FILTER_VALIDATE_EMAIL)
    ) {
      // Invalid email address, redirect with error
      header("Location: /login?error=invalid_email");
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
          header("Location: /login?error=email_send_failed");
          exit();
        }

        header("Location: /login?success=reset_link_sent");
        exit();
      } else {
        // Failed to save token, redirect with error
        header("Location: /login?error=token_save_failed");
        exit();
      }
    } else {
      // User does not exist, redirect with error
      header("Location: /login?error=user_not_found");
      exit();
    }
  }

  // Display the password reset form.
  public function resetPasswordForm($token)
  {
    if (empty($token)) {
      // No token provided, redirect with error
      header("Location: /login?error=no_token_provided");
      exit();
    }

    $user = new User();
    $userData = $user->findUserByResetToken($token);

    // Validate the token
    if ($userData) {
      require "../src/Views/password/reset.php";
    } else {
      // Invalid token, redirect with error
      header("Location: /login?error=invalid_token");
      exit();
    }
  }

  // Handle the password reset submission.
  public function handleResetPassword($data)
  {
    if (
      empty($data["token"]) ||
      empty($data["password"]) ||
      strlen($data["password"]) < 6
    ) {
      // Invalid input, redirect with error
      header("Location: /login?error=invalid_input");
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

        header("Location: /login?success=password_reset");
        exit();
      } else {
        // Failed to update password, redirect with error
        header("Location: /login?error=password_update_failed");
        exit();
      }
    } else {
      // Invalid token, redirect with error
      header("Location: /login?error=invalid_token");
      exit();
    }
  }
}
