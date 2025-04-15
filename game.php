<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Game Ular</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f5f5f5;
      text-align: center;
      background-color: burlywood;
    }
    canvas {
      background: #000;
      display: block;
      margin: 20px auto;
      border: 3px solid #4CAF50;
    }
    .scoreboard {
      font-size: 18px;
      margin-top: 10px;
    }
    .navbar {
      padding: 15px;
      background-color: #4CAF50;
    }
    .navbar a {
      color: white;
      margin: 0 10px;
      text-decoration: none;
    }
    .score-popup {
      position: absolute;
      color: green;
      font-weight: bold;
      animation: fadeUp 1s forwards;
    }
    @keyframes fadeUp {
      0% { opacity: 1; transform: translateY(0); }
      100% { opacity: 0; transform: translateY(-30px); }
    }
  </style>
</head>
<body>

<div class="navbar">
  <a href="home.php">Home</a>
  <a href="index.php">Tugas</a>
  <a href="game.php" style="font-weight: bold;">Game</a>
</div>

<canvas id="game" width="400" height="400"></canvas>
<div class="scoreboard">
  Skor: <span id="score">0</span> | Waktu: <span id="timer">100</span> detik
</div>

<audio id="gameover-sound" src="https://www.myinstants.com/media/sounds/gameover.mp3"></audio>
<audio id="win-sound" src="https://vgmsite.com/soundtracks/super-mario-world/jsgzblxb/01%20Opening.mp3"></audio>

<script>
const canvas = document.getElementById("game");
const ctx = canvas.getContext("2d");
const box = 20;

let score = 0;
let timer = 100;
let snake = [{ x: 10 * box, y: 10 * box }];
let food = {
  x: Math.floor(Math.random() * 20) * box,
  y: Math.floor(Math.random() * 20) * box
};
let direction = "RIGHT";

const gameOverSound = document.getElementById("gameover-sound");
const winSound = document.getElementById("win-sound");

document.addEventListener("keydown", function(e) {
  if (e.key === "ArrowLeft" && direction !== "RIGHT") direction = "LEFT";
  if (e.key === "ArrowUp" && direction !== "DOWN") direction = "UP";
  if (e.key === "ArrowRight" && direction !== "LEFT") direction = "RIGHT";
  if (e.key === "ArrowDown" && direction !== "UP") direction = "DOWN";
});

function showScorePopup(x, y) {
  const popup = document.createElement("div");
  popup.className = "score-popup";
  popup.textContent = "+1!";
  popup.style.left = canvas.offsetLeft + x + "px";
  popup.style.top = canvas.offsetTop + y + "px";
  document.body.appendChild(popup);
  setTimeout(() => document.body.removeChild(popup), 1000);
}

function draw() {
  ctx.fillStyle = "#000";
  ctx.fillRect(0, 0, canvas.width, canvas.height);

  for (let i = 0; i < snake.length; i++) {
    ctx.fillStyle = i === 0 ? "#4CAF50" : "white";
    ctx.fillRect(snake[i].x, snake[i].y, box, box);
  }

  ctx.fillStyle = "red";
  ctx.fillRect(food.x, food.y, box, box);

  let headX = snake[0].x;
  let headY = snake[0].y;

  if (direction === "LEFT") {
    headX -= box;
    if (headX < 0) {
      headX = 0;
      direction = "RIGHT";
    }
  }
  if (direction === "UP") {
    headY -= box;
    if (headY < 0) {
      headY = 0;
      direction = "DOWN";
    }
  }
  if (direction === "RIGHT") {
    headX += box;
    if (headX >= canvas.width) {
      headX = canvas.width - box;
      direction = "LEFT";
    }
  }
  if (direction === "DOWN") {
    headY += box;
    if (headY >= canvas.height) {
      headY = canvas.height - box;
      direction = "UP";
    }
  }

  const newHead = { x: headX, y: headY };

  if (headX === food.x && headY === food.y) {
    score++;
    document.getElementById("score").textContent = score;
    showScorePopup(headX, headY);
    food = {
      x: Math.floor(Math.random() * 20) * box,
      y: Math.floor(Math.random() * 20) * box
    };

    if (score >= 10) {
      clearInterval(gameInterval);
      clearInterval(countdown);
      winSound.play();

      Swal.fire({
        title: 'Kamu Menang!',
        text: `Skor kamu: ${score}`,
        icon: 'success',
        showCancelButton: true,
        confirmButtonText: 'Main Lagi',
        cancelButtonText: 'Kembali ke Task Manager',
        confirmButtonColor: '#4CAF50',
        cancelButtonColor: '#d33'
      }).then((result) => {
        if (result.isConfirmed) {
          location.reload();
        } else {
          window.location.href = "index.php";
        }
      });

      return;
    }

  } else {
    snake.pop();
  }

  snake.unshift(newHead);
}

function gameOver() {
  clearInterval(gameInterval);
  clearInterval(countdown);
  gameOverSound.play();

  Swal.fire({
    title: 'Waktu Habis!',
    text: score >= 10
      ? `Hebat! Skor kamu: ${score}`
      : `Yah, skor kamu ${score}. Ayo coba lagi!`,
    icon: 'info',
    showCancelButton: true,
    confirmButtonText: 'Main Lagi',
    cancelButtonText: 'Kembali ke Task Manager',
    confirmButtonColor: '#4CAF50',
    cancelButtonColor: '#d33'
  }).then((result) => {
    if (result.isConfirmed) {
      location.reload();
    } else {
      window.location.href = "index.php";
    }
  });
}

const gameInterval = setInterval(draw, 150);
const countdown = setInterval(() => {
  timer--;
  document.getElementById("timer").textContent = timer;
  if (timer <= 0) {
    gameOver();
  }
}, 1000);
</script>

</body>
</html>