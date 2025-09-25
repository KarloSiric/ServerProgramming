<?php
// Lab 3 Events Page - Using PDO with database
require_once __DIR__ . '/../model/EventModelLab3.php';

$eventModel = new EventModelLab3();
$events = $eventModel->getAllEventsFromDB();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 3 - Event Management with PDO</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 30px;
        }
        h1 {
            color: #333;
            border-bottom: 3px solid #667eea;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }
        .lab-info {
            background: #667eea;
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background: #667eea;
            color: white;
            padding: 15px;
            text-align: left;
        }
        td {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
        }
        tr:hover {
            background: #f8f9ff;
        }
        .attendees-link {
            background: #3498db;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            text-decoration: none;
            display: inline-block;
            font-weight: bold;
        }
        .attendees-link:hover {
            background: #2980b9;
        }
        .no-data {
            text-align: center;
            padding: 50px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>ISTE-341 Lab 3 - Event Management with PDO</h1>
        
        <div class="lab-info">
            <strong>Lab 3 Requirements Met:</strong>
            <ul style="margin: 10px 0 0 20px;">
                <li>✓ Using PDO for database access</li>
                <li>✓ JOIN operation to get venue names</li>
                <li>✓ Showing registered/allowed attendees count</li>
                <li>✓ Clickable attendee numbers linking to TODO page</li>
            </ul>
        </div>

        <?php if (empty($events)): ?>
            <div class="no-data">
                <h2>No Events Found</h2>
                <p>Please add some data to your database:</p>
                <pre style="text-align: left; background: #f5f5f5; padding: 20px; border-radius: 5px;">
-- Add venues
INSERT INTO venue (name, capacity) VALUES 
('Main Conference Hall', 100),
('Workshop Room A', 50);

-- Add events
INSERT INTO event (name, start_date, end_date, allowed_number, venue_id) VALUES
('Tech Summit 2024', '2024-12-01 09:00:00', '2024-12-01 17:00:00', 100, 1),
('Web Dev Workshop', '2024-12-05 10:00:00', '2024-12-05 15:00:00', 50, 2);

-- Add registrations
INSERT INTO attendee_event (attendee_id, event_id, paid) VALUES
(1, 1, 1), (2, 1, 1), (1, 2, 1);
                </pre>
            </div>
        <?php else: ?>
            <h2>All Events</h2>
            <table>
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Venue</th>
                        <th>Attendees</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($events as $event): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($event['event_name']) ?></strong></td>
                            <td><?= date('M d, Y H:i', strtotime($event['start_date'])) ?></td>
                            <td><?= date('M d, Y H:i', strtotime($event['end_date'])) ?></td>
                            <td><?= htmlspecialchars($event['venue_name'] ?? 'No venue') ?></td>
                            <td>
                                <a href="lab3_attendees.php?event_id=<?= $event['event_id'] ?>" 
                                   class="attendees-link">
                                    <?= $event['registered_attendees'] ?> / <?= $event['max_attendees'] ?>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
