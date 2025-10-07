<?php
// config.php
declare(strict_types=1);
session_start();

// === XAMPP Defaults ===
$db_host = 'localhost';
$db_name = 'wat website';
$db_user = 'root';
$db_pass = ''; // In XAMPP standardmäßig leer lassen

$dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";
$options = [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
  $pdo = new PDO($dsn, $db_user, $db_pass, $options);
} catch (PDOException $e) {
  http_response_code(500);
  exit('DB-Verbindung fehlgeschlagen.');
}

function is_logged_in(): bool { return isset($_SESSION['user_id']); }
function require_login(): void {
  if (!is_logged_in()) {
    header('Location: login.php');
    exit;
  }
}
