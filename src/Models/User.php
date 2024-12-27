<?php
namespace EasyTodo\Models;

use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class User {
    // Other properties and methods

    public function sendPasswordReset($email) {
        $token = bin2hex(random_bytes(50));
        // Save the token in the database with an expiration time

        $transport = (new Swift_SmtpTransport($_ENV['SMTP_HOST'], $_ENV['SMTP_PORT']))
            ->setUsername($_ENV['SMTP_USER'])
            ->setPassword($_ENV['SMTP_PASS']);

        $mailer = new Swift_Mailer($transport);

        $message = (new Swift_Message('Password Reset'))
            ->setFrom(['no-reply@example.com' => 'EasyTodo'])
            ->setTo([$email])
            ->setBody("Here is your password reset link: http://example.com/reset_password?token=$token");

        $mailer->send($message);
    }

    public function resetPassword($token, $newPassword) {
        // Verify the token and reset the password
    }
}