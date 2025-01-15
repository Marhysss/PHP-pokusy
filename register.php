<?php
session_start();
require 'includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $connection->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        echo "Registrace byla úspěšná!";
        header('Location: login.php'); 
        exit;
    } else {
        echo "Chyba při registraci.";
    }

    $stmt->close();
}

?>

<form method="POST" action="register.php">
    <input type="text" name="username" placeholder="Uživatelské jméno" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Heslo" required>
    <button type="submit">Registrovat</button>
</form>
