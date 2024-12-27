<?php

namespace EasyTodo\Models;

use PDO;
use EasyTodo\Config\Database;

class User
{
  private $db;

  public function __construct()
  {
    $this->db = Database::getConnection();
  }

  public function register(string $name, string $email, string $password): bool
  {
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $sql =
      "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";

    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":password", $hashedPassword);

    return $stmt->execute();
  }

  public function login(string $email, string $password): bool
  {
    $sql = "SELECT * FROM users WHERE email = :email";

    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["password"])) {
      $_SESSION["name"] = $user["name"];
      return true;
    }

    return false;
  }

  public function getUserById(int $id): ?array
  {
    $sql = "SELECT * FROM users WHERE id = :id";

    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
  }

  // Password reset methods
  public function findUserByEmail(string $email): ?array
  {
    $sql = "SELECT * FROM users WHERE email = :email";

    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
  }

  public function savePasswordResetToken(string $email, string $token): bool
  {
    $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

    $sql =
      "UPDATE users SET reset_token = :token, reset_token_expiry = :expiry WHERE email = :email";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(":token", $token);
    $stmt->bindParam(":expiry", $expiry);
    $stmt->bindParam(":email", $email);

    return $stmt->execute();
  }

  public function findUserByResetToken(string $token): ?array
  {
    $sql =
      "SELECT * FROM users WHERE reset_token = :token AND reset_token_expiry > NOW()";

    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(":token", $token);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
  }

  public function resetPassword(int $userId, string $password): bool
  {
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $sql =
      "UPDATE users SET password = :password, reset_token = NULL, reset_token_expiry = NULL WHERE id = :id";

    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(":password", $hashedPassword);
    $stmt->bindParam(":id", $userId);

    return $stmt->execute();
  }
}
