<?php
require 'db.php';
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name'] ?? '');
    $comment = trim($_POST['comment'] ?? '');
    if ($name === '' || mb_strlen($name) > 100) {
        $msg = "Name is required (max 100 characters).";
    } elseif ($comment === '' || mb_strlen($comment) > 1000) {
        $msg = "Feedback is required (max 1000 characters).";
    } else {
        $stmt = $conn->prepare("INSERT INTO feedback (name, comment) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $comment);
        $msg = $stmt->execute() ? "Feedback submitted!" : "Could not save feedback.";
    }
}
$result = $conn->query("SELECT * FROM feedback ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Feedback - Rogue AP Detection System</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    body { font-family: Arial, sans-serif; display: flex; justify-content: center; padding-top: 40px; }
    .box { width: 560px; padding: 24px; border: 1px solid #999; border-radius: 8px; }
    input, textarea, button { width: 100%; padding: 10px; margin: 6px 0; box-sizing: border-box; }
    table { width: 100%; border-collapse: collapse; margin-top: 12px; }
    th, td { border: 1px solid #999; padding: 8px; text-align: left; }
  </style>
</head>
<body>
  <div class="box">
    <h2>System Feedback</h2>
    <p><?= htmlspecialchars($msg) ?></p>
    <form method="post">
      <input name="name" maxlength="100" placeholder="Your name" required>
      <textarea name="comment" maxlength="1000" placeholder="Your feedback on the detection system" required></textarea>
      <button type="submit">Submit</button>
    </form>
    <h3>Submitted entries</h3>
    <table>
      <tr><th>ID</th><th>Name</th><th>Comment</th><th>Time</th></tr>
      <?php while ($r = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $r['id'] ?></td>
        <td><?= htmlspecialchars($r['name']) ?></td>
        <td><?= htmlspecialchars($r['comment']) ?></td>
        <td><?= htmlspecialchars($r['created_at']) ?></td>
      </tr>
      <?php endwhile; ?>
    </table>
  </div>
</body>
</html>
