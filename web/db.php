<?php
$cfg = parse_ini_file('/etc/isproject1/db.env');
if ($cfg === false) { die("Server configuration error."); }
$conn = new mysqli($cfg['DB_HOST'], $cfg['DB_USER'], $cfg['DB_PASS'], $cfg['DB_NAME']);
if ($conn->connect_error) {
    error_log("DB connection failed: " . $conn->connect_error);
    die("Service temporarily unavailable.");
}
$conn->set_charset("utf8mb4");
