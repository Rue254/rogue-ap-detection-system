<?php
require 'db.php';
session_set_cookie_params(['domain' => '.rogueapdetec.me', 'httponly' => true, 'samesite' => 'Lax']);
session_start();
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u  = trim($_POST['username'] ?? '');
    $pw = $_POST['password'] ?? '';
    if ($u === '' || strlen($u) > 30 || $pw === '' || strlen($pw) > 72) {
        $msg = "Invalid username or password.";
    } else {
        $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->bind_param("s", $u);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        if ($row && password_verify($pw, $row['password'])) {
            session_regenerate_id(true);
            $_SESSION['user'] = $u;
            $msg = "Login successful. Welcome, " . htmlspecialchars($u, ENT_QUOTES) . "!";
        } else {
            $msg = "Invalid username or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Login - Rogue AP Detection System</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    body { font-family: Arial, sans-serif; display: flex; justify-content: center; padding-top: 60px; }
    .box { width: 320px; padding: 24px; border: 1px solid #999; border-radius: 8px; }
    input, button { width: 100%; padding: 10px; margin: 6px 0; box-sizing: border-box; }
  </style>
</head>
<body>
  <div class="box">
    <h2>Login</h2>
    <p><?= htmlspecialchars($msg) ?></p>
    <form method="post">
      <input name="username" maxlength="30" placeholder="Username" required>
      <input name="password" maxlength="72" type="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
    <p>No account? <a href="register.php">Sign up</a></p>
  </div>
</body>
</html>
