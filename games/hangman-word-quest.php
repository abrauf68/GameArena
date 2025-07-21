<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Hangman Word Quest</title>
  <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:wght@400;700&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Comic Neue', cursive, sans-serif;
      margin: 0;
      padding: 0;
    }

    body {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background: linear-gradient(135deg, #ff6b6b, #ff8e53);
      transition: background 0.5s;
    }

    body.dark-mode {
      background: linear-gradient(135deg, #2c3e50, #4b6584);
    }

    .game-container {
      background: white;
      padding: 1.5rem;
      border-radius: 15px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
      max-width: 90%;
      width: 600px;
      text-align: center;
      transition: background 0.3s, color 0.3s;
    }

    .dark-mode .game-container {
      background: #34495e;
      color: #e0e0e0;
    }

    h1 {
      color: #2c3e50;
      font-size: clamp(1.8rem, 5vw, 2.2rem);
      margin-bottom: 1rem;
    }

    .dark-mode h1 {
      color: #e0e0e0;
    }

    .settings {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1rem;
      flex-wrap: wrap;
      gap: 0.5rem;
    }

    .difficulty-select {
      padding: 0.5rem;
      font-size: clamp(0.9rem, 2.5vw, 1rem);
      border-radius: 5px;
      border: 1px solid #ccc;
      cursor: pointer;
      flex: 1;
      max-width: 150px;
    }

    .dark-mode .difficulty-select {
      background: #3e3e5f;
      color: #e0e0e0;
      border-color: #555;
    }

    .theme-toggle {
      padding: 0.5rem 1rem;
      background: #ff6b6b;
      color: white;
      border: none;
      border-radius: 5px;
      font-size: clamp(0.9rem, 2.5vw, 1rem);
      cursor: pointer;
      transition: background 0.3s;
      flex: 1;
      max-width: 150px;
    }

    .theme-toggle:hover {
      background: #ff8e53;
    }

    .progress-bar {
      width: 100%;
      height: 8px;
      background: #ddd;
      border-radius: 5px;
      margin: 1rem 0;
      overflow: hidden;
    }

    .progress {
      height: 100%;
      background: #28a745;
      transition: width 0.3s ease;
    }

    .dark-mode .progress-bar {
      background: #555;
    }

    .hearts-display {
      font-size: clamp(1.8rem, 5vw, 2.2rem);
      height: 60px;
      margin: 1rem 0;
      display: flex;
      justify-content: center;
      gap: 0.5rem;
      transition: opacity 0.3s ease;
    }

    .heart {
      transition: transform 0.3s ease;
    }

    .heart.lost {
      color: #ccc;
      transform: scale(0.8);
      opacity: 0.5;
    }

    .dark-mode .heart.lost {
      color: #777;
    }

    .word-display {
      font-size: clamp(1.6rem, 4vw, 2rem);
      margin: 1rem 0;
      display: flex;
      justify-content: center;
      gap: clamp(6px, 2vw, 10px);
      flex-wrap: wrap;
    }

    .letter {
      width: clamp(25px, 6vw, 35px);
      height: clamp(25px, 6vw, 35px);
      line-height: clamp(25px, 6vw, 35px);
      border-bottom: 3px solid #333;
      font-weight: bold;
      transition: transform 0.2s ease, border-color 0.2s ease;
    }

    .dark-mode .letter {
      border-bottom-color: #e0e0e0;
    }

    .letter.correct {
      color: #28a745;
      border-bottom-color: #28a745;
      transform: scale(1.1);
      animation: pop 0.3s ease;
    }

    .letter.wrong {
      color: #dc3545;
      border-bottom-color: #dc3545;
      animation: shake 0.3s ease;
    }

    .wrong-letters {
      margin: 1rem 0;
      color: #dc3545;
      font-size: clamp(1rem, 2.5vw, 1.2rem);
    }

    .dark-mode .wrong-letters {
      color: #ff6b6b;
    }

    .keyboard {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(40px, 1fr));
      gap: clamp(6px, 2vw, 8px);
      margin: 1rem 0;
    }

    .key-button {
      padding: clamp(8px, 2vw, 10px);
      font-size: clamp(0.9rem, 2.5vw, 1.1rem);
      cursor: pointer;
      border: none;
      background: #ff6b6b;
      color: white;
      border-radius: 6px;
      transition: transform 0.2s ease, background 0.2s ease;
    }

    .key-button:hover:not(.disabled) {
      background: #ff8e53;
      transform: scale(1.05);
    }

    .key-button.disabled {
      background: #ccc;
      color: #777;
      pointer-events: none;
    }

    .dark-mode .key-button {
      background: #3e3e5f;
    }

    .dark-mode .key-button:hover:not(.disabled) {
      background: #5e5e7f;
    }

    .message {
      margin: 1rem 0;
      font-size: clamp(1.2rem, 3vw, 1.4rem);
      font-weight: bold;
      color: #2c3e50;
      animation: fadeIn 0.5s ease;
    }

    .dark-mode .message {
      color: #e0e0e0;
    }

    .score {
      font-size: clamp(1rem, 2.5vw, 1.2rem);
      margin: 0.5rem 0;
      color: #2c3e50;
    }

    .dark-mode .score {
      color: #e0e0e0;
    }

    .hint-btn, .play-again {
      margin: 0.5rem;
      padding: clamp(0.6rem, 2vw, 0.8rem) clamp(1rem, 3vw, 1.2rem);
      background: #28a745;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: clamp(0.9rem, 2.5vw, 1rem);
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .hint-btn:hover, .play-again:hover {
      background: #218838;
    }

    @keyframes pop {
      0% { transform: scale(1); }
      50% { transform: scale(1.2); }
      100% { transform: scale(1.1); }
    }

    @keyframes shake {
      0% { transform: translateX(0); }
      25% { transform: translateX(-5px); }
      50% { transform: translateX(5px); }
      75% { transform: translateX(-5px); }
      100% { transform: translateX(0); }
    }

    @keyframes fadeIn {
      0% { opacity: 0; }
      100% { opacity: 1; }
    }

    @media (max-width: 600px) {
      .game-container {
        padding: 1rem;
        width: 95%;
      }

      .settings {
        flex-direction: column;
        align-items: stretch;
      }

      .difficulty-select, .theme-toggle {
        max-width: 100%;
      }

      .hearts-display {
        font-size: 1.6rem;
        height: 40px;
        gap: 0.3rem;
      }

      .word-display {
        font-size: 1.4rem;
        gap: 6px;
      }

      .letter {
        width: 25px;
        height: 25px;
        line-height: 25px;
      }

      .key-button {
        padding: 8px;
        font-size: 0.9rem;
      }

      .message {
        font-size: 1.2rem;
      }
    }

    @media (max-width: 400px) {
      .keyboard {
        grid-template-columns: repeat(auto-fit, minmax(35px, 1fr));
      }
    }
  </style>
</head>
<body>
  <div class="game-container">
    <h1>Hangman Word Quest</h1>
    <div class="settings">
      <select class="difficulty-select" id="difficultySelect">
        <option value="easy">Easy</option>
        <option value="medium" selected>Medium</option>
        <option value="hard">Hard</option>
      </select>
      <button class="theme-toggle" id="themeToggle">Toggle Dark Mode</button>
    </div>
    <div class="score" id="score">Score: 0</div>
    <div class="progress-bar">
      <div class="progress" id="progress"></div>
    </div>
    <div class="hearts-display" id="heartsDisplay" aria-live="polite"></div>
    <div class="word-display" id="wordDisplay" aria-live="polite"></div>
    <div class="wrong-letters" id="wrongLetters"></div>
    <div class="keyboard" id="keyboard"></div>
    <div class="message" id="message"></div>
    <button class="hint-btn" id="hintBtn">Get Hint (-10 points)</button>
    <button class="play-again" id="playAgainBtn" style="display: none;">Play Again</button>
  </div>

  <audio id="correctSound" src="https://www.soundjay.com/buttons/beep-01a.mp3"></audio>
  <audio id="wrongSound" src="https://www.soundjay.com/buttons/beep-02.mp3"></audio>
  <audio id="winSound" src="https://www.soundjay.com/misc/sounds/cheer-1.mp3"></audio>
  <audio id="loseSound" src="https://www.soundjay.com/misc/sounds/fail-1.mp3"></audio>

  <script>
    const wordLists = {
      easy: ["cat", "dog", "bird", "fish", "tree", "sun", "moon", "star"],
      medium: ["javascript", "hangman", "developer", "interface", "algorithm"],
      hard: ["cryptography", "blockchain", "quantum", "neuralnet", "asynchronous"]
    };

    let selectedWord = "";
    let correctLetters = [];
    let wrongLetters = [];
    let score = 0;
    const maxWrongGuesses = 5; // Fixed to 5 for heart system
    let difficulty = "medium";

    const elements = {
      wordDisplay: document.getElementById("wordDisplay"),
      heartsDisplay: document.getElementById("heartsDisplay"),
      wrongLetters: document.getElementById("wrongLetters"),
      message: document.getElementById("message"),
      keyboard: document.getElementById("keyboard"),
      playAgainBtn: document.getElementById("playAgainBtn"),
      hintBtn: document.getElementById("hintBtn"),
      difficultySelect: document.getElementById("difficultySelect"),
      themeToggle: document.getElementById("themeToggle"),
      score: document.getElementById("score"),
      progress: document.getElementById("progress"),
      sounds: {
        correct: document.getElementById("correctSound"),
        wrong: document.getElementById("wrongSound"),
        win: document.getElementById("winSound"),
        lose: document.getElementById("loseSound")
      }
    };

    function startGame() {
      difficulty = elements.difficultySelect.value;
      selectedWord = wordLists[difficulty][Math.floor(Math.random() * wordLists[difficulty].length)];
      correctLetters = [];
      wrongLetters = [];
      updateDOM();
      enableButtons();
      elements.message.textContent = "";
      elements.playAgainBtn.style.display = "none";
      elements.hintBtn.style.display = "inline-block";
      updateProgress();
    }

    function updateDOM() {
      // Update word display
      elements.wordDisplay.innerHTML = selectedWord
        .split("")
        .map(letter =>
          `<span class="letter ${correctLetters.includes(letter) ? "correct" : ""}">${correctLetters.includes(letter) ? letter : ""}</span>`
        )
        .join("");

      // Update hearts display
      const hearts = Array(maxWrongGuesses).fill("❤️").map((heart, index) =>
        `<span class="heart ${index < wrongLetters.length ? "lost" : ""}">${heart}</span>`
      ).join("");
      elements.heartsDisplay.innerHTML = hearts;

      // Update wrong letters
      elements.wrongLetters.textContent = wrongLetters.length > 0 ? `Wrong: ${wrongLetters.join(", ")}` : "";

      // Update score
      elements.score.textContent = `Score: ${score}`;

      // Update progress bar
      updateProgress();

      // Check win or lose
      if (correctLetters.length === [...new Set(selectedWord)].length) {
        const points = (maxWrongGuesses - wrongLetters.length) * (difficulty === "easy" ? 5 : difficulty === "medium" ? 10 : 15);
        score += points;
        elements.message.textContent = `🎉 You Win! +${points} points!`;
        elements.sounds.win.play().catch(() => {});
        disableButtons();
        elements.playAgainBtn.style.display = "inline-block";
        elements.hintBtn.style.display = "none";
      } else if (wrongLetters.length >= maxWrongGuesses) {
        score = Math.max(0, score - 10);
        elements.message.textContent = `💔 You Lose! The word was "${selectedWord}"`;
        elements.sounds.lose.play().catch(() => {});
        disableButtons();
        elements.playAgainBtn.style.display = "inline-block";
        elements.hintBtn.style.display = "none";
      }
    }

    function updateProgress() {
      const progressPercent = ((maxWrongGuesses - wrongLetters.length) / maxWrongGuesses) * 100;
      elements.progress.style.width = `${progressPercent}%`;
      elements.progress.style.background = progressPercent > 50 ? "#28a745" : progressPercent > 25 ? "#ffc107" : "#dc3545";
    }

    function handleKeyPress(letter, button) {
      if (correctLetters.includes(letter) || wrongLetters.includes(letter)) return;

      if (selectedWord.includes(letter)) {
        correctLetters.push(letter);
        elements.sounds.correct.play().catch(() => {});
      } else {
        wrongLetters.push(letter);
        elements.sounds.wrong.play().catch(() => {});
      }

      button.classList.add("disabled");
      updateDOM();
    }

    function getHint() {
      if (score < 10 || correctLetters.length >= selectedWord.length) return;
      score -= 10;
      const unguessedLetters = selectedWord.split("").filter(l => !correctLetters.includes(l));
      if (unguessedLetters.length > 0) {
        const hintLetter = unguessedLetters[Math.floor(Math.random() * unguessedLetters.length)];
        correctLetters.push(hintLetter);
        const button = [...document.querySelectorAll(".key-button")].find(b => b.textContent === hintLetter);
        if (button) button.classList.add("disabled");
        updateDOM();
      }
    }

    function createKeyboard() {
      const alphabet = "abcdefghijklmnopqrstuvwxyz";
      elements.keyboard.innerHTML = "";
      alphabet.split("").forEach(letter => {
        const button = document.createElement("button");
        button.classList.add("key-button");
        button.textContent = letter;
        button.setAttribute("aria-label", `Guess letter ${letter}`);
        button.addEventListener("click", () => handleKeyPress(letter, button));
        elements.keyboard.appendChild(button);
      });
    }

    function disableButtons() {
      document.querySelectorAll(".key-button").forEach(btn => btn.classList.add("disabled"));
    }

    function enableButtons() {
      document.querySelectorAll(".key-button").forEach(btn => btn.classList.remove("disabled"));
    }

    // Event Listeners
    elements.playAgainBtn.addEventListener("click", startGame);
    elements.hintBtn.addEventListener("click", getHint);
    elements.difficultySelect.addEventListener("change", startGame);
    elements.themeToggle.addEventListener("click", () => {
      document.body.classList.toggle("dark-mode");
      elements.gameContainer.classList.toggle("dark-mode");
    });

    // Keyboard input
    window.addEventListener("keydown", e => {
      if (/^[a-zA-Z]$/.test(e.key)) {
        const letter = e.key.toLowerCase();
        const button = [...document.querySelectorAll(".key-button")].find(b => b.textContent === letter);
        if (button && !button.classList.contains("disabled")) {
          handleKeyPress(letter, button);
        }
      }
    });

    // Initialize game
    createKeyboard();
    startGame();
  </script>
</body>
</html>