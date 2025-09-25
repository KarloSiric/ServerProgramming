<?php
// Lab 3 Attendees TODO Page
$event_id = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 3 - Attendees TODO</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .todo-container {
            background: white;
            padding: 50px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 500px;
        }
        h1 {
            color: #667eea;
        }
        .info {
            background: #f8f9ff;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .back-btn {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 12px 30px;
            border-radius: 25px;
            text-decoration: none;
            margin-top: 20px;
        }
        .back-btn:hover {
            background: #5569d8;
        }
    </style>
</head>
<body>
    <div class="todo-container">
        <h1>TODO</h1>
        <div class="info">
            <p><strong>Event ID:</strong> <?= htmlspecialchars($event_id) ?></p>
            <p>This page will display the list of attendees for the selected event.</p>
        </div>
        <p>As required by Lab 3, this is a placeholder page.</p>
        <a href="lab3_events.php" class="back-btn">← Back to Events</a>
    </div>
</body>
</html>
