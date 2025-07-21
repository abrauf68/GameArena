<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sudoku Game</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            color: #e0e0e0;
            padding: 1rem;
            overscroll-behavior: none;
        }

        .container {
            background: #24243e;
            padding: clamp(1rem, 5vw, 1.5rem);
            border-radius: 1rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
            width: min(90vw, 600px);
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        h1 {
            font-size: clamp(1.8rem, 5vw, 2.2rem);
            color: #60a5fa;
            margin-bottom: 1rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .timer {
            font-size: clamp(1rem, 3vw, 1.2rem);
            color: #a3bffa;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        .sudoku-board {
            display: grid;
            grid-template-columns: repeat(9, minmax(30px, 1fr));
            gap: 2px;
            background: #1a1a2e;
            padding: 0.5rem;
            border-radius: 0.5rem;
            border: 2px solid #3b3b5a;
            width: 100%;
            aspect-ratio: 1/1;
        }

        .cell {
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: clamp(1rem, 3.5vw, 1.4rem);
            background: #2a2a4a;
            border: 1px solid #3b3b5a;
            border-radius: 0.25rem;
            cursor: pointer;
            transition: all 0.2s ease;
            aspect-ratio: 1/1;
            color: #e0e0e0;
            font-weight: 500;
            touch-action: manipulation;
        }

        .cell:hover:not(.pregenerated) {
            background: #3b3b5a;
            transform: scale(1.05);
        }

        .cell.pregenerated {
            background: #3b3b5a;
            font-weight: 600;
            color: #93c5fd;
            cursor: default;
        }

        .cell.invalid {
            background: #7f1d1d;
            animation: shake 0.3s;
        }

        .cell.selected {
            background: #2563eb;
            border: 2px solid #60a5fa;
            color: #ffffff;
            transform: scale(1.05);
        }

        .controls {
            margin: 1.5rem 0;
            display: flex;
            justify-content: center;
            gap: 0.75rem;
        }

        button {
            padding: 0.75rem 1.5rem;
            font-size: clamp(0.9rem, 2.5vw, 1rem);
            border: none;
            border-radius: 0.5rem;
            background: linear-gradient(45deg, #2563eb, #60a5fa);
            color: #ffffff;
            cursor: pointer;
            transition: all 0.2s ease;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            touch-action: manipulation;
        }

        button:hover {
            background: linear-gradient(45deg, #1e40af, #3b82f6);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        button:active {
            transform: translateY(0);
            box-shadow: none;
        }

        .number-pad {
            display: grid;
            grid-template-columns: repeat(5, minmax(40px, 1fr));
            gap: 0.5rem;
            margin: 1.5rem auto;
            max-width: 300px;
        }

        .number-pad button {
            padding: 0;
            font-size: clamp(1rem, 3vw, 1.2rem);
            aspect-ratio: 1/1;
            background: #2a2a4a;
            border: 1px solid #3b3b5a;
            border-radius: 0.25rem;
        }

        .number-pad button:hover {
            background: #3b3b5a;
            transform: scale(1.05);
        }

        .message {
            font-size: clamp(1rem, 3vw, 1.2rem);
            color: #34d399;
            margin-top: 1rem;
            font-weight: 500;
            display: none;
            animation: fadeIn 0.5s;
        }

        /* 3x3 subgrid borders */
        .cell:nth-child(3n):not(:nth-child(9n)) {
            border-right: 2px solid #3b3b5a;
        }

        .cell:nth-child(n+19):nth-child(-n+27),
        .cell:nth-child(n+46):nth-child(-n+54) {
            border-bottom: 2px solid #3b3b5a;
        }

        /* Animations */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-3px); }
            75% { transform: translateX(3px); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Responsive adjustments */
        @media (max-width: 480px) {
            .container {
                padding: 0.75rem;
                width: 95vw;
            }

            .sudoku-board {
                grid-template-columns: repeat(9, minmax(25px, 1fr));
                gap: 1px;
                padding: 0.25rem;
            }

            .cell {
                font-size: clamp(0.8rem, 3vw, 1rem);
            }

            .number-pad {
                grid-template-columns: repeat(5, minmax(30px, 1fr));
                gap: 0.4rem;
                max-width: 250px;
            }

            button {
                padding: 0.5rem 1rem;
                font-size: clamp(0.8rem, 2.5vw, 0.9rem);
            }

            .controls {
                flex-direction: row;
                gap: 0.5rem;
            }
        }

        @media (min-width: 768px) {
            .container {
                width: 80vw;
                max-width: 700px;
            }

            .sudoku-board {
                grid-template-columns: repeat(9, minmax(40px, 1fr));
                gap: 3px;
            }

            .cell {
                font-size: clamp(1.2rem, 3vw, 1.6rem);
            }

            .number-pad {
                max-width: 350px;
            }
        }

        @media (max-width: 360px) {
            .sudoku-board {
                grid-template-columns: repeat(9, minmax(20px, 1fr));
            }

            .cell {
                font-size: clamp(0.7rem, 2.8vw, 0.9rem);
            }

            .number-pad {
                grid-template-columns: repeat(5, minmax(25px, 1fr));
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Sudoku</h1>
        <div class="timer">Time: <span id="timer">00:00</span></div>
        <div class="sudoku-board" id="sudoku-board"></div>
        <div class="controls">
            <button onclick="resetBoard()">Reset</button>
            <button onclick="checkSolution()">Check Solution</button>
        </div>
        <div class="number-pad" id="number-pad"></div>
        <div class="message" id="message"></div>
    </div>

    <script>
        // JavaScript remains unchanged as per your request
        const initialBoard = [
            [5,3,0,0,7,0,0,0,0],
            [6,0,0,1,9,5,0,0,0],
            [0,9,8,0,0,0,0,6,0],
            [8,0,0,0,6,0,0,0,3],
            [4,0,0,8,0,3,0,0,1],
            [7,0,0,0,2,0,0,0,6],
            [0,6,0,0,0,0,2,8,0],
            [0,0,0,4,1,9,0,0,5],
            [0,0,0,0,8,0,0,7,9]
        ];

        const solution = [
            [5,3,4,6,7,8,9,1,2],
            [6,7,2,1,9,5,3,4,8],
            [1,9,8,3,4,2,5,6,7],
            [8,5,9,7,6,1,4,2,3],
            [4,2,6,8,5,3,7,9,1],
            [7,1,3,9,2,4,8,5,6],
            [9,6,1,5,3,7,2,8,4],
            [2,8,7,4,1,9,6,3,5],
            [3,4,5,2,8,6,1,7,9]
        ];

        let board = JSON.parse(JSON.stringify(initialBoard));
        let selectedCell = null;
        let timerInterval;
        let seconds = 0;

        function initializeBoard() {
            const boardElement = document.getElementById('sudoku-board');
            boardElement.innerHTML = '';
            for (let i = 0; i < 9; i++) {
                for (let j = 0; j < 9; j++) {
                    const cell = document.createElement('div');
                    cell.classList.add('cell');
                    if (initialBoard[i][j] !== 0) {
                        cell.classList.add('pregenerated');
                        cell.textContent = initialBoard[i][j];
                    }
                    cell.addEventListener('click', () => selectCell(cell, i, j));
                    cell.addEventListener('touchstart', (e) => {
                        e.preventDefault();
                        selectCell(cell, i, j);
                    });
                    boardElement.appendChild(cell);
                }
            }
            updateBoard();
        }

        function initializeNumberPad() {
            const numberPad = document.getElementById('number-pad');
            numberPad.innerHTML = '';
            for (let i = 1; i <= 9; i++) {
                const button = document.createElement('button');
                button.textContent = i;
                button.addEventListener('click', () => inputNumber(i));
                button.addEventListener('touchstart', (e) => {
                    e.preventDefault();
                    inputNumber(i);
                });
                numberPad.appendChild(button);
            }
            const eraseButton = document.createElement('button');
            eraseButton.textContent = 'X';
            eraseButton.addEventListener('click', () => inputNumber(0));
            eraseButton.addEventListener('touchstart', (e) => {
                e.preventDefault();
                inputNumber(0);
            });
            numberPad.appendChild(eraseButton);
        }

        function selectCell(cell, row, col) {
            if (cell.classList.contains('pregenerated')) return;
            if (selectedCell) {
                selectedCell.classList.remove('selected');
            }
            selectedCell = cell;
            selectedCell.classList.add('selected');
            selectedCell.dataset.row = row;
            selectedCell.dataset.col = col;
        }

        function inputNumber(number) {
            if (!selectedCell) return;
            const row = parseInt(selectedCell.dataset.row);
            const col = parseInt(selectedCell.dataset.col);
            board[row][col] = number;
            updateBoard();
            validateCell(row, col, number);
            selectedCell.classList.remove('selected');
            selectedCell = null;
        }

        function updateBoard() {
            const cells = document.querySelectorAll('.cell');
            cells.forEach((cell, index) => {
                const row = Math.floor(index / 9);
                const col = index % 9;
                cell.textContent = board[row][col] !== 0 ? board[row][col] : '';
                cell.classList.remove('invalid');
            });
        }

        function validateCell(row, col, number) {
            const cell = document.querySelector(`.cell:nth-child(${row * 9 + col + 1})`);
            if (number === 0) {
                cell.classList.remove('invalid');
                return;
            }
            for (let j = 0; j < 9; j++) {
                if (j !== col && board[row][j] === number) {
                    cell.classList.add('invalid');
                    return;
                }
            }
            for (let i = 0; i < 9; i++) {
                if (i !== row && board[i][col] === number) {
                    cell.classList.add('invalid');
                    return;
                }
            }
            const startRow = Math.floor(row / 3) * 3;
            const startCol = Math.floor(col / 3) * 3;
            for (let i = startRow; i < startRow + 3; i++) {
                for (let j = startCol; j < startCol + 3; j++) {
                    if ((i !== row || j !== col) && board[i][j] === number) {
                        cell.classList.add('invalid');
                        return;
                    }
                }
            }
            cell.classList.remove('invalid');
        }

        function checkSolution() {
            let correct = true;
            for (let i = 0; i < 9; i++) {
                for (let j = 0; j < 9; j++) {
                    if (board[i][j] !== solution[i][j]) {
                        correct = false;
                        break;
                    }
                }
                if (!correct) break;
            }
            const message = document.getElementById('message');
            message.style.display = 'block';
            if (correct) {
                message.textContent = 'Congratulations! You solved the puzzle!';
                clearInterval(timerInterval);
            } else {
                message.textContent = 'Incorrect solution. Keep trying!';
                setTimeout(() => {
                    message.style.display = 'none';
                }, 2000);
            }
        }

        function resetBoard() {
            board = JSON.parse(JSON.stringify(initialBoard));
            updateBoard();
            seconds = 0;
            updateTimer();
            document.getElementById('message').style.display = 'none';
        }

        function startTimer() {
            timerInterval = setInterval(() => {
                seconds++;
                updateTimer();
            }, 1000);
        }

        function updateTimer() {
            const minutes = Math.floor(seconds / 60);
            const secs = seconds % 60;
            document.getElementById('timer').textContent = 
                `${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
        }

        initializeBoard();
        initializeNumberPad();
        startTimer();
    </script>
</body>
</html>