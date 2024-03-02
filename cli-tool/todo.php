<?php
require 'config.php';
require 'db.php';

$command = $_SERVER['argv'][1];

switch ($command) {
    case 'list':
        $filter = $_SERVER['argv'][2] ?? null;
        $filter = ($filter == 'pending' || $filter == 'done') ? $filter : 'pending';
        $results = query("SELECT * FROM todo WHERE status = '$filter'");
        while ($row = mysqli_fetch_assoc($results)) {
            echo $row['id'] . " - " . $row['text'] . " (" . $row['status'] . ")\n";
        }
        break;

    case 'add':
        $text = $_SERVER['argv'][2];
        query("INSERT INTO todo (text, status) VALUES ('$text', 'pending')");
        echo "Task added successfully\n";
        break;
        
    case 'update':
        $id = $_SERVER['argv'][2];
        $status = $_SERVER['argv'][3];
        query("UPDATE todo SET status = '$status' WHERE id = $id");
        echo "Task updated\n";   
        break; 

    case 'remove':
        $id = $_SERVER['argv'][2];
        query("DELETE FROM todo WHERE id = $id");
        echo "Task deleted\n";
        break;

    case 'pending':
    case 'done':
        $id = $_SERVER['argv'][2]; 
        $status = ($command == 'pending') ? 'pending' : 'done';
        query("UPDATE todo SET status = '$status' WHERE id = $id");
        echo "Task status updated\n";
        break;

    case 'help':
        echo "Usage: php todo.php [command] [arguments]\n";
        echo "Available commands:\n";
        echo "  list [pending|done] - List all tasks\n";
        echo "  add [task] - Add a new task\n";
        echo "  update [id] [pending|done] - Update a task\n";
        echo "  remove [id] - Remove a task\n";
        echo "  pending [id] - Mark a task as pending\n";
        echo "  done [id] - Mark a task as done\n";
        
        break;

    default:
        echo "Invalid command!\n";
        break;
}

?>
