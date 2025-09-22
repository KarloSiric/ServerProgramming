<!DOCTYPE html>
<html>
<head>
    <title>CSS Test</title>
    <style>
        body { font-family: Arial; margin: 40px; }
        .test { background: #f0f0f0; padding: 20px; border-radius: 8px; }
    </style>
</head>
<body>
    <div class="test">
        <h2>EventHorizon CSS Test</h2>
        <p>If you can see this styled, the basic HTML works.</p>
        <p>CSS file should be at: css/style.css</p>
        <p>Image should be at: img/Project1_LogoImage.png</p>
        
        <h3>Server Path Info:</h3>
        <p>SCRIPT_NAME: <?= $_SERVER['SCRIPT_NAME'] ?? 'undefined' ?></p>
        <p>REQUEST_URI: <?= $_SERVER['REQUEST_URI'] ?? 'undefined' ?></p>
        <p>DOCUMENT_ROOT: <?= $_SERVER['DOCUMENT_ROOT'] ?? 'undefined' ?></p>
        
        <h3>File Checks:</h3>
        <p>css/style.css exists: <?= file_exists('css/style.css') ? 'YES' : 'NO' ?></p>
        <p>img/Project1_LogoImage.png exists: <?= file_exists('img/Project1_LogoImage.png') ? 'YES' : 'NO' ?></p>
    </div>
</body>
</html>
