<?php
session_start();
require 'includes/db_connect.php';

$stmt = $connection->prepare("SELECT id, username FROM users");
$stmt->execute();
$result = $stmt->get_result();
$users = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $password = $_POST['password'];

    $stmt = $connection->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();

    if (password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $user_id;
        header('Location: index.php');
        exit;
    } else {
        echo "Nesprávné heslo.";
    }

    $stmt->close();
}
?>

<form method="POST" action="login.php">
    <label for="user_id">Vyber uživatele:</label>
    <select name="user_id" id="user_id">
        <?php foreach ($users as $user): ?>
            <option value="<?= htmlspecialchars($user['id']) ?>">
                <?= htmlspecialchars($user['username']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <input type="password" name="password" placeholder="Heslo" required>
    <button type="submit">Přihlásit se</button>
</form>
