<?php
$servername = "localhost";
$dbname = "wat website";   // <-- dein DB-Name
$dbuser = "root";       
$dbpass = "";           

$conn = new mysqli($servername, $dbuser, $dbpass, $dbname);

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        $message = "<div class='notice'>Registrierung erfolgreich! <a href='login.php'>Zum Login</a></div>";
    } else {
        $message = "<div class='error'>Fehler: " . $conn->error . "</div>";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registrieren</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="card">
        <h2>Registrieren</h2>
        <?= $message ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Benutzername" required>
            <input type="email" name="email" placeholder="E-Mail" required>
            <input type="password" name="password" placeholder="Passwort" required>
            <button type="submit">Registrieren</button>
        </form>
        <p><a href="login.php">Schon ein Konto? Einloggen</a></p>
        <button onclick="window.location.href='index.html'">⬅ Zurück</button>
    </div>
</body>
</html>
