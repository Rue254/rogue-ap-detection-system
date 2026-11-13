<?php
$conn = new mysqli("localhost", "cat2user", "Cat2Pass#123", "CAT2");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
