<?php
$servername = "localhost";
$dbname = "wat website";   
$dbuser = "root";       
$dbpass = "";           

$conn = new mysqli($servername, $dbuser, $dbpass, $dbname);

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hash);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        if (password_verify($password, $hash)) {
            session_start();
            $_SESSION["user_id"] = $id;
            $message = "<div class='notice'>Login erfolgreich! Willkommen " . htmlspecialchars($username) . "</div>";
        } else {
            $message = "<div class='error'>Falsches Passwort!</div>";
        }
    } else {
        $message = "<div class='error'>Benutzer nicht gefunden!</div>";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="card">
        <h2>Login</h2>
        <?= $message ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Benutzername" required>
            <input type="password" name="password" placeholder="Passwort" required>
            <button type="submit">Login</button>
        </form>
        <p><a href="register.php">Noch kein Konto? Registrieren</a></p>
        <button onclick="window.location.href='index.html'">⬅ Zurück</button>
    </div>
</body>
</html>
