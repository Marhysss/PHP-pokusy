<?php
session_start();
require 'includes/db_connect.php';


if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $stmt = $connection->prepare("SELECT username FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($username);
    $stmt->fetch();
    $stmt->close();
    

    $stmt = $connection->prepare("SELECT * FROM tasks WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $username = ""; 
}

?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>fr jen tak pokus</title>
</head>
<body>

<h1>pokus jedna :D </h1>

<?php if (isset($_SESSION['user_id'])): ?>
    <p>Přihlášen jako: <strong><?php echo htmlspecialchars($username); ?></strong></p>
    <a href="add_task.php">Přidat nový úkol</a>

    <ul>
    <?php while ($row = $result->fetch_assoc()): ?>
        <li>
            <strong><?php echo htmlspecialchars($row['title']); ?></strong> - <?php echo htmlspecialchars($row['status']); ?>
        </li>
    <?php endwhile; ?>
    </ul>

    <a href="logout.php">Odhlásit se</a>

<?php else: ?>
    <p></p>
    <a href="login.php">Přihlásit se</a>
    <br>
    <a href="register.php">Registrovat</a>
<?php endif; ?>

</body>
</html>

<?php
if (isset($result)) {
    $stmt->close();
}
$connection->close();
?>
