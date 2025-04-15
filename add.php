<?php
include 'db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $task = trim($_POST['task']);

    if ($task !== '') {
        $stmt = $conn->prepare("INSERT INTO tasks (task) VALUES (?)");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("s", $task);
        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }
    } else {
        die("Tugas tidak boleh kosong!");
    }
}

header("Location: index.php");
exit();