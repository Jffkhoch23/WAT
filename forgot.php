<?php
require "config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];

    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        $token = bin2hex(random_bytes(32));
        $expires = date("Y-m-d H:i:s", strtotime("+1 hour"));

        $stmt = $pdo->prepare("INSERT INTO password_resets (user_id, token, expires) VALUES (?, ?, ?)");
        $stmt->execute([$user["id"], $token, $expires]);

        $resetLink = "http://localhost/reset.php?token=$token";
        mail($email, "Passwort zurücksetzen", "Klicke hier: $resetLink");
    }

    $message = "Wenn die E-Mail existiert, wurde ein Reset-Link geschickt.";
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Passwort zurücksetzen</title>
  <link rel="stylesheet" href="design.css">
</head>
<body>
<div class="card">
  <h2>Passwort vergessen?</h2>
  <?php if (!empty($message)) echo "<div class='notice'>$message</div>"; ?>
  <form method="POST">
    <input type="email" name="email" placeholder="Deine E-Mail" required>
    <button type="submit">Link anfordern</button>
  </form>
  <a href="login.php">← Zurück zum Login</a>
</div>
</body>
</html>
