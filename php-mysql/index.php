<?php 
require 'connect_db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TODO List</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js"></script>
</head>
<body>
<div class="container">
    <div class="add-section">
        <form action="add.php" method="POST" autocomplete="off">
                <input type="text" 
                    name="title" 
                    placeholder="Start taking notes!" />
                <button type="submit">Add</button>
        </form>
    </div>
    <?php 
        $todos = $conn->query("SELECT * FROM todos ORDER BY id DESC");
    ?>

    <div class="show-todo-section">
        <?php if($todos->rowCount() === 0){ ?>
            <div class="todo-item">
                <div class="empty">
                    <div></div>
                    <div>Nothing to do! Add a task?</div>
                </div>
            </div>
        <?php } ?>

        <?php while($todo = $todos->fetch(PDO::FETCH_ASSOC)) { ?>
            <div class="todo-item" id="<?php echo $todo['id']; ?>">
                <span id="<?php echo $todo['id']; ?>" class="remove-to-do">
                    <button onclick="deleteTodo(<?php echo $todo['id']; ?>)">X</button>
                </span>
                <div class="checkbox-container">
                    <input type="checkbox" name="checked" id="todo_<?php echo $todo['id']; ?>" 
                           data-todo-id="<?php echo $todo['id']; ?>" <?php if ($todo['checked']) echo 'checked'; ?> 
                           onchange="checkTodo(this)">
                    <label for="todo_<?php echo $todo['id']; ?>"></label>
                </div>
                <h2><?php echo $todo['title'] ?></h2>
                <small><?php echo $todo['date_time'] ?></small> 
            </div>
        <?php } ?>
    </div>
</div>

</body>
</html>