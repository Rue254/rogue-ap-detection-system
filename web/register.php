<?php
require 'db.php';
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u  = trim($_POST['username'] ?? '');
    $e  = trim($_POST['email'] ?? '');
    $pw = $_POST['password'] ?? '';
    if (!preg_match('/^[A-Za-z0-9_]{3,30}$/', $u)) {
        $msg = "Username must be 3-30 characters: letters, digits or underscore.";
    } elseif (!filter_var($e, FILTER_VALIDATE_EMAIL) || strlen($e) > 100) {
        $msg = "Please enter a valid email address.";
    } elseif (strlen($pw) < 8 || strlen($pw) > 72) {
        $msg = "Password must be 8-72 characters.";
    } else {
        $p = password_hash($pw, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $u, $e, $p);
        if ($stmt->execute()) {
            $msg = "User '" . htmlspecialchars($u, ENT_QUOTES) . "' registered successfully!";
        } elseif ($conn->errno === 1062) {
            $msg = "That username is already taken.";
        } else {
            error_log("Register error: " . $conn->error);
            $msg = "Registration failed. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Sign Up - Rogue AP Detection System</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    body { font-family: Arial, sans-serif; display: flex; justify-content: center; padding-top: 60px; }
    .box { width: 320px; padding: 24px; border: 1px solid #999; border-radius: 8px; }
    input, button { width: 100%; padding: 10px; margin: 6px 0; box-sizing: border-box; }
  </style>
</head>
<body>
  <div class="box">
    <h2>Sign Up</h2>
    <p><?= htmlspecialchars($msg) ?></p>
    <form method="post">
      <input name="username" minlength="3" maxlength="30" pattern="[A-Za-z0-9_]+" title="3-30 letters, digits or underscore" placeholder="Username" required>
      <input name="email" type="email" maxlength="100" type="email" placeholder="Email">
      <input name="password" minlength="8" maxlength="72" type="password" placeholder="Password" required>
      <button type="submit">Register</button>
    </form>
    <p>Already registered? <a href="login.php">Login</a></p>
  </div>
</body>
</html>
