<?php
// Test database connection
echo "<h1>Testing Database Connection</h1>";

// Try no password
try {
    $pdo = new PDO("mysql:host=localhost;dbname=db_eventhorizon", "root", "");
    echo "✅ SUCCESS with NO password<br>";
    echo "Use: password=<br>";
} catch(PDOException $e) {
    echo "❌ Failed with no password<br>";
}

// Try password 'root'
try {
    $pdo = new PDO("mysql:host=localhost;dbname=db_eventhorizon", "root", "root");
    echo "✅ SUCCESS with password 'root'<br>";
    echo "Use: password=root<br>";
} catch(PDOException $e) {
    echo "❌ Failed with password 'root'<br>";
}
?>
