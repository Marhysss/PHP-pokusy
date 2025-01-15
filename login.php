<?php
session_start();
require 'includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $connection->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($id, $hashed_password);
    $stmt->fetch();

    if (password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $id;
        header('Location: index.php');
        exit;
    } else {
        echo "Nesprávné uživatelské jméno nebo heslo.";
    }

    $stmt->close();
}

?>

<form method="POST" action="login.php">
    <input type="text" name="username" placeholder="Uživatelské jméno" required>
    <input type="password" name="password" placeholder="Heslo" required>
    <button type="submit">Přihlásit se</button>
</form>
