<?php
echo "<h1>Config Debug</h1>";

$configPath = __DIR__ . '/app/config/config.ini';
echo "Config path: $configPath<br>";

if (file_exists($configPath)) {
    echo "Config file exists<br>";
    
    // Show raw file content
    echo "<h2>Raw file content:</h2>";
    echo "<pre>" . htmlspecialchars(file_get_contents($configPath)) . "</pre>";
    
    // Parse the file
    echo "<h2>Parsed config:</h2>";
    $config = parse_ini_file($configPath, true);
    echo "<pre>";
    var_dump($config);
    echo "</pre>";
    
    if ($config && isset($config['db'])) {
        echo "<h2>Individual values:</h2>";
        echo "DSN: '" . $config['db']['dsn'] . "'<br>";
        echo "Username: '" . $config['db']['username'] . "'<br>";
        echo "Password: '" . $config['db']['password'] . "'<br>";
        
        // Test if DSN looks valid
        if (strpos($config['db']['dsn'], 'mysql:') === 0) {
            echo "DSN starts with mysql: - looks good<br>";
        } else {
            echo "DSN does NOT start with mysql: - this is the problem!<br>";
        }
    }
} else {
    echo "Config file does NOT exist<br>";
}
?>
