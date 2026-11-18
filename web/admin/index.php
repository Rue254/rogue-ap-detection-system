<?php session_start(); ?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Admin Panel</title></head>
<body style="font-family:Arial;max-width:600px;margin:60px auto">
<h1>Admin Panel</h1>
<p>Rogue AP Detection System: administration area.</p>
<p>Logged in user: <?= htmlspecialchars($_SESSION['user'] ?? 'not logged in') ?></p>
</body></html>
