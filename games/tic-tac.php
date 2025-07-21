<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tic Tac Toe</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background: linear-gradient(to right, #6a11cb, #2575fc);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      color: white;
    }

    .container {
      text-align: center;
    }

    h1 {
      margin-bottom: 20px;
      font-size: 2.5em;
    }

    .board {
      display: grid;
      grid-template-columns: repeat(3, 100px);
      grid-template-rows: repeat(3, 100px);
      gap: 10px;
      justify-content: center;
      margin-bottom: 20px;
    }

    .cell {
      background-color: rgba(255, 255, 255, 0.1);
      font-size: 2.5em;
      display: flex;
      justify-content: center;
      align-items: center;
      cursor: pointer;
      transition: background-color 0.3s;
      border-radius: 10px;
    }

    .cell:hover {
      background-color: rgba(255, 255, 255, 0.2);
    }

    .status {
      font-size: 1.2em;
      margin-bottom: 15px;
    }

    button {
      background-color: white;
      color: #2575fc;
      border: none;
      padding: 10px 20px;
      font-size: 1em;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    button:hover {
      background-color: #f0f0f0;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Tic Tac Toe</h1>
    <div class="status" id="status">Player X's turn</div>
    <div class="board" id="board">
      <!-- 9 cells will be inserted by JavaScript -->
    </div>
    <button onclick="resetGame()">Restart Game</button>
  </div>

  <script>
    const board = document.getElementById("board");
    const statusText = document.getElementById("status");

    let currentPlayer = "X";
    let gameActive = true;
    let gameState = ["", "", "", "", "", "", "", "", ""];

    const winningConditions = [
      [0, 1, 2],
      [3, 4, 5],
      [6, 7, 8],
      [0, 3, 6],
      [1, 4, 7],
      [2, 5, 8],
      [0, 4, 8],
      [2, 4, 6]
    ];

    function handleCellClick(event) {
      const cell = event.target;
      const index = parseInt(cell.getAttribute("data-cell"));

      if (gameState[index] !== "" || !gameActive) return;

      gameState[index] = currentPlayer;
      cell.textContent = currentPlayer;

      if (checkWin()) {
        statusText.textContent = `Player ${currentPlayer} wins!`;
        gameActive = false;
        return;
      }

      if (!gameState.includes("")) {
        statusText.textContent = "It's a draw!";
        gameActive = false;
        return;
      }

      currentPlayer = currentPlayer === "X" ? "O" : "X";
      statusText.textContent = `Player ${currentPlayer}'s turn`;
    }

    function checkWin() {
      return winningConditions.some(condition => {
        const [a, b, c] = condition;
        return (
          gameState[a] &&
          gameState[a] === gameState[b] &&
          gameState[a] === gameState[c]
        );
      });
    }

    function resetGame() {
      gameState = ["", "", "", "", "", "", "", "", ""];
      currentPlayer = "X";
      gameActive = true;
      statusText.textContent = `Player ${currentPlayer}'s turn`;
      Array.from(board.children).forEach(cell => {
        cell.textContent = "";
      });
    }

    function createBoard() {
      board.innerHTML = "";
      for (let i = 0; i < 9; i++) {
        const cell = document.createElement("div");
        cell.classList.add("cell");
        cell.setAttribute("data-cell", i);
        cell.addEventListener("click", handleCellClick);
        board.appendChild(cell);
      }
    }

    createBoard();
  </script>
</body>
</html>