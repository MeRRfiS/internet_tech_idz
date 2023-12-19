let currentPlayer = 1;
let moves = 0;
let gameOver = false;
let playerWins = 0;
let botWins = 0;
let gamesPlayed = 0;
let playerMode = 'player';

function startGame() {
    currentPlayer = Math.floor(Math.random() * 2) + 1;
    moves = 0;
    gameOver = false;

    if (playerMode === 'bot' && currentPlayer === 2) {
        makeBotMove();
    } else {
        document.getElementById('status').textContent = `${getPlayerName()}, your turn`;
    }
}

function changePlayerMode() {
    playerMode = document.getElementById('playerMode').value;

    playerWins = 0;
    botWins = 0;
    document.getElementById('playerScore').textContent = 'Player 1 (X): 0 wins';
    document.getElementById('botScore').textContent = 'Player 2 (O): 0 wins';

    resetGame();
}

function makeMove(cell) {
    if (!cell.textContent && !gameOver) {
        cell.textContent = currentPlayer === 1 ? 'X' : 'O';
        moves++;

        if (checkWinner()) {
            displayWinner();
            updateScore();
            updateGamesPlayed();
            gameOver = true;
        } else if (moves === 9) {
            document.getElementById('status').textContent = 'The game ended in a draw!';
            updateGamesPlayed();
            gameOver = true;
        } else {
            currentPlayer = currentPlayer === 1 ? 2 : 1;
            document.getElementById('status').textContent = `${getPlayerName()}, your turn`;

            if (playerMode === 'bot' && currentPlayer === 2) {
                makeBotMove();
            }
        }
    }
}

function makeBotMove() {
    const emptyCells = Array.from(document.getElementsByClassName('cell')).filter(cell => !cell.textContent);
    if (emptyCells.length > 0 && !gameOver) {
        const randomIndex = Math.floor(Math.random() * emptyCells.length);
        const botMove = emptyCells[randomIndex];
        botMove.textContent = 'O';
        moves++;

        if (checkWinner()) {
            displayWinner();
            updateScore();
            updateGamesPlayed();
            gameOver = true;
        } else if (moves === 9) {
            document.getElementById('status').textContent = 'The game ended in a draw!';
            updateGamesPlayed();
            gameOver = true;
        } else {
            currentPlayer = 1;
            document.getElementById('status').textContent = `${getPlayerName()}, your turn`;
        }
    }
}

function getPlayerName() {
    return playerMode === 'bot' && currentPlayer === 2 ? 'Player 2' : `Player ${currentPlayer}`;
}

function checkWinner() {
    const board = document.getElementsByClassName('cell');
    const winPatterns = [
        [0, 1, 2], [3, 4, 5], [6, 7, 8], // rows
        [0, 3, 6], [1, 4, 7], [2, 5, 8], // columns
        [0, 4, 8], [2, 4, 6]             // diagonals
    ];

    for (const pattern of winPatterns) {
        const [a, b, c] = pattern;
        if (board[a].textContent && board[a].textContent === board[b].textContent && board[a].textContent === board[c].textContent) {
            return true;
        }
    }

    return false;
}

function displayWinner() {
    document.getElementById('status').textContent = `Player ${currentPlayer} is winer!`;
}

function updateScore() {
    if (currentPlayer === 1) {
        playerWins++;
        document.getElementById('playerScore').textContent = `Player 1 (X): ${playerWins} wins`;
    } else {
        botWins++;
        document.getElementById('botScore').textContent = `Player 2 (O): ${botWins} wins`;
    }
}

function updateGamesPlayed() {
    gamesPlayed++;
    document.getElementById('gamesPlayed').textContent = `Game played: ${gamesPlayed}`;
}

function resetGame() {
    const cells = document.getElementsByClassName('cell');
    for (const cell of cells) {
        cell.textContent = '';
    }

    startGame();
}

window.addEventListener('load', function () {
    startGame();
});
