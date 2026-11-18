<?php
require 'db.php';
session_set_cookie_params(['domain' => '.yourrealdomain.me', 'httponly' => true, 'samesite' => 'Lax']);
session_start();
