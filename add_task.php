<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require 'includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];
    $priority = $_POST['priority'];

    $stmt = $connection->prepare("INSERT INTO tasks (user_id, title, description, due_date, priority) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $user_id, $title, $description, $due_date, $priority);

    if ($stmt->execute()) {
        header('Location: index.php');
        exit;
    } else {
        echo "Chyba při přidávání úkolu.";
    }

    $stmt->close();
}

?>

<form method="POST" action="add_task.php">
    <input type="text" name="title" placeholder="Název úkolu" required>
    <textarea name="description" placeholder="Popis"></textarea>
    <input type="date" name="due_date">
    <select name="priority">
        <option value="low">Nízká</option>
        <option value="medium">Střední</option>
        <option value="high">Vysoká</option>
    </select>
    <button type="submit">Přidat úkol</button>
</form>
