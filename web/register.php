<?php
require 'db.php';
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = trim($_POST['username']);
    $e = trim($_POST['email']);
    $p = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $u, $e, $p);
    if ($stmt->execute()) {
        $msg = "User '" . $u . "' registered successfully!";
    } else {
        $msg = "Error: " . $conn->error;
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
      <input name="username" placeholder="Username" required>
      <input name="email" type="email" placeholder="Email">
      <input name="password" type="password" placeholder="Password" required>
      <button type="submit">Register</button>
    </form>
    <p>Already registered? <a href="login.php">Login</a></p>
  </div>
</body>
</html>
