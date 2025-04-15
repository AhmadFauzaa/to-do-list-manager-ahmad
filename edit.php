<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM tasks WHERE id = $id");
    $task = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = intval($_POST['id']);
    $newTask = trim($_POST['task']);
    if ($newTask !== '') {
        $stmt = $conn->prepare("UPDATE tasks SET task = ? WHERE id = ?");
        $stmt->bind_param("si", $newTask, $id);
        $stmt->execute();
    }
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Tugas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Edit Tugas</h1>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $task['id'] ?>">
        <input type="text" name="task" value="<?= htmlspecialchars($task['task']) ?>" required>
        <button type="submit">Simpan</button>
    </form>
</div>
</body>
</html>