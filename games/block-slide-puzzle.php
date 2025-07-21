<!DOCTYPE html>
<html dir="ltr" lang="en">

<?php include '../layout/head.php' ?>

<body>
  <style>
    main {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      /* overflow-y: hidden; */
      padding: 0;
      padding-top: 100px;
    }

    .gameContainer h1 {
      margin-bottom: 30px;
      font-size: 2.5rem;
      font-weight: 700;
      background: linear-gradient(90deg, #6b7280, #60a5fa);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      text-shadow: 0 0 10px rgba(96, 165, 250, 0.3);
      text-align: center;
    }

    .game-container {
      display: grid;
      grid-template-columns: repeat(4, 100px);
      grid-template-rows: repeat(4, 100px);
      gap: 8px;
      background: #0f172a;
      padding: 10px;
      border-radius: 16px;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5), inset 0 0 10px rgba(255, 255, 255, 0.05);
    }

    .gameContainer .tile {
      width: 100px;
      height: 100px;
      background: linear-gradient(145deg, #2d3748, #1f2937);
      color: #e0e0e0;
      font-size: 1.5rem;
      font-weight: 600;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 12px;
      cursor: pointer;
      transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
      user-select: none;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .gameContainer .tile:hover {
      transform: translateY(-4px);
      box-shadow: 0 4px 16px rgba(59, 130, 246, 0.4);
      background: linear-gradient(145deg, #3b82f6, #2563eb);
    }

    .gameContainer .empty {
      background: rgba(255, 255, 255, 0.05);
      pointer-events: none;
      border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .gameContainer .controls {
      margin-top: 30px;
      text-align: center;
    }

    .gameContainer button {
      padding: 12px 24px;
      font-size: 1rem;
      font-weight: 600;
      border: none;
      border-radius: 8px;
      background: linear-gradient(90deg, #3b82f6, #60a5fa);
      color: white;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .gameContainer button:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(59, 130, 246, 0.5);
      background: linear-gradient(90deg, #2563eb, #3b82f6);
    }

    .gameContainer button:active {
      transform: translateY(0);
      box-shadow: 0 2px 8px rgba(59, 130, 246, 0.2);
    }

    @media (max-width: 500px) {
      .gameContainer h1 {
        font-size: 1.8rem;
      }

      .game-container {
        grid-template-columns: repeat(4, 70px);
        grid-template-rows: repeat(4, 70px);
        gap: 5px;
        padding: 8px;
      }

      .gameContainer .tile {
        width: 70px;
        height: 70px;
        font-size: 1.2rem;
        border-radius: 10px;
      }

      .gameContainer button {
        padding: 10px 20px;
        font-size: 0.9rem;
      }
    }
  </style>

  <!-- preloader start -->
  <?php include '../layout/preloader.php' ?>
  <!-- preloader end -->

  <!-- scroll to top button start -->
  <button class="scroll-to-top show" id="scrollToTop">
    <i class="ti ti-arrow-up"></i>
  </button>
  <!-- scroll to top button end -->

  <!-- header start -->
  <?php include '../layout/header.php' ?>
  <!-- header end -->

  <!-- sidebar start -->
  <?php include '../layout/sidebar.php' ?>
  <!-- sidebar end -->

  <!-- app layout start -->
  <div class="app-layout">
    <!-- main start -->
    <main>
      <div class="gameContainer">
        <h1>Slide The Block</h1>
        <div class="game-container" id="game"></div>
        <div class="controls">
          <button onclick="shuffle()">Shuffle</button>
        </div>
      </div>
    </main>
    <!-- main end -->
  </div>
  <!-- app layout end -->

  <script>
    const size = 4; // 4x4 puzzle
    let tiles = [];
    let emptyIndex;

    const gameContainer = document.getElementById('game');

    function createTiles() {
      tiles = Array.from({
        length: size * size - 1
      }, (_, i) => i + 1);
      tiles.push(null); // empty tile
      emptyIndex = size * size - 1;
    }

    function renderTiles() {
      gameContainer.innerHTML = '';
      tiles.forEach((tile, index) => {
        const div = document.createElement('div');
        div.className = 'tile';
        if (tile === null) {
          div.classList.add('empty');
        } else {
          div.textContent = tile;
          div.addEventListener('click', () => moveTile(index));
        }
        gameContainer.appendChild(div);
      });
    }

    function isAdjacent(i1, i2) {
      const row1 = Math.floor(i1 / size),
        col1 = i1 % size;
      const row2 = Math.floor(i2 / size),
        col2 = i2 % size;
      return (Math.abs(row1 - row2) + Math.abs(col1 - col2)) === 1;
    }

    function moveTile(index) {
      if (!isAdjacent(index, emptyIndex)) return;
      [tiles[index], tiles[emptyIndex]] = [tiles[emptyIndex], tiles[index]];
      emptyIndex = index;
      renderTiles();
      checkWin();
    }

    function shuffle() {
      for (let i = 0; i < 200; i++) {
        const neighbors = getNeighbors(emptyIndex);
        const randomNeighbor = neighbors[Math.floor(Math.random() * neighbors.length)];
        [tiles[emptyIndex], tiles[randomNeighbor]] = [tiles[randomNeighbor], tiles[emptyIndex]];
        emptyIndex = randomNeighbor;
      }
      renderTiles();
    }

    function getNeighbors(index) {
      const neighbors = [];
      const row = Math.floor(index / size);
      const col = index % size;
      if (row > 0) neighbors.push(index - size);
      if (row < size - 1) neighbors.push(index + size);
      if (col > 0) neighbors.push(index - 1);
      if (col < size - 1) neighbors.push(index + 1);
      return neighbors;
    }

    function checkWin() {
      for (let i = 0; i < tiles.length - 1; i++) {
        if (tiles[i] !== i + 1) return;
      }
      setTimeout(() => {
        alert("🎉 You solved the puzzle!");
      }, 200);
    }

    // Initialize
    createTiles();
    renderTiles();
  </script>
</body>

</html>