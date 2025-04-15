<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Task Manager PHP</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
<div class="navbar" align="center">
    <a href="game.php" class="active">Mini Game</a>
    <a href="home.php">Kembali</a>
</div>
<div class="container">
    <h1>Task Manager</h1>
    <form action="add.php" method="POST" class="task-input" id="taskForm">
    <input type="text" name="task" placeholder="Masukkan tugas..." id="taskInput">
    <button type="submit">Tambah</button>
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById("taskForm").addEventListener("submit", function(e) {
    var input = document.getElementById("taskInput").value.trim();
    if (input === "") {
        e.preventDefault(); // Stop kirim form
        Swal.fire({
            icon: 'warning',
            title: 'Oops!',
            text: 'TUGAS TIDAK BOLEH KOSONG!',
            confirmButtonColor: '#3085d6'
        });
    }
});
</script>
</script>

    <ul>
    <?php
$result = $conn->query("SELECT * FROM tasks ORDER BY id DESC");

if ($result === false) {
    echo "Query error: " . $conn->error;
} else {
    while ($row = $result->fetch_assoc()):
?>
    <li>
        <span><?= htmlspecialchars($row['task']) ?></span>
        <div><a href="#" class="edit" onclick="confirmEdit(<?= $row['id'] ?>)">Edit</a>
        <a href="#" class="delete" onclick="confirmDelete(<?= $row['id'] ?>)">Hapus</a>
            
        </div>
    </li>
<?php
    endwhile;
}
?>
    </ul>
</div>
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Tugas akan dihapus permanen.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e74c3c',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'delete.php?id=' + id;
        }
    });
}

function confirmEdit(id) {
    Swal.fire({
        title: 'Yakin ingin mengedit?',
        text: "Anda akan diarahkan ke halaman edit.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#f39c12',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, edit'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'edit.php?id=' + id;
        }
    });
}
</script>
<a href="game.php" style="
  position: fixed;
  bottom: 20px;
  right: 20px;
  background-color: red;
  color: white;
  padding: 10px 15px;
  font-size: 14px;
  border-radius: 30px;
  text-decoration: none;
  box-shadow: 0 4px 6px rgba(0,0,0,0.2);
  transition: background 0.3s ease;
" onmouseover="this.style.backgroundColor='#cc0000'" onmouseout="this.style.backgroundColor='red'">
  Main Game
</a>
</body>
</html>