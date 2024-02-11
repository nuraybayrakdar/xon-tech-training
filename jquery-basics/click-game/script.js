$(document).ready(function() {
    const $target = $('#target');
    const $scoreValue = $('#score-value');
    const $difficultyLevel = $('#difficulty-level');
    const $timer = $('#timer');

    let score = 0;
    let targetSpeed = 2; 
    let timeLeft = 15;
    let timeInterval;

    function moveTarget() {
        const currentLeft = parseInt($target.css('left'));
        const newLeft = currentLeft + targetSpeed;
        $target.css('left', newLeft + 'px');

        
        if (newLeft > 500) {
            generateRandomPosition();
        }

        
        requestAnimationFrame(moveTarget);
    }

    function generateRandomPosition() {
        const randomY = Math.floor(Math.random() * 450); 
        $target.css('top', randomY + 'px');
        $target.css('left', '0px');
    }
    
    function setTargetSpeed(difficulty) {
        switch (difficulty) {
            case '1':
                targetSpeed = 2;
                break;
            case '2':
                targetSpeed = 5;
                break;
            case '3':
                targetSpeed = 8;
                break;
            default:
                targetSpeed = 2;
        }
    }

    $target.on('click', function() {
        score++;
        $scoreValue.text(score);
        generateRandomPosition();
    });

    $difficultyLevel.on('change', function() {
        score = 0;
        timeLeft = 15;
        $scoreValue.text(score);
        $timer.text(timeLeft);
        const selectedDifficulty = $(this).val();
        setTargetSpeed(selectedDifficulty);
    });

    function startTimer() {
        timeInterval = setInterval(function() {
            timeLeft--;
            $timer.text(timeLeft);
            if (timeLeft === 0) {
                clearInterval(timeInterval);
                alert('Game Over! Your score is ' + score);
                score = 0;
                $scoreValue.text(score);
                timeLeft = 15;
                $timer.text(timeLeft);
            }
        }, 1000);
    }

    generateRandomPosition();
    startTimer();
    moveTarget();
});