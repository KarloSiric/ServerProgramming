<!DOCTYPE html>
<html>
<head>
    <title>Image Test</title>
    <style>body { font-family: Arial; margin: 40px; }</style>
</head>
<body>
    <h2>Image Loading Test</h2>
    
    <h3>Logo Test:</h3>
    <img src="/~ks9700/iste-341/Project1/public/img/Project1_LogoImage.png" style="width: 100px; border: 1px solid red;" alt="Logo" onload="this.style.border='1px solid green'" onerror="this.style.border='1px solid red'; this.alt='FAILED TO LOAD'">
    
    <h3>Event Images Test:</h3>
    <img src="/~ks9700/iste-341/Project1/public/img/Project1_image1.png" style="width: 200px; border: 1px solid red;" alt="Event 1" onload="this.style.border='1px solid green'" onerror="this.style.border='1px solid red'; this.alt='FAILED TO LOAD'">
    <br><br>
    <img src="/~ks9700/iste-341/Project1/public/img/Project1_Image2.png" style="width: 200px; border: 1px solid red;" alt="Event 2" onload="this.style.border='1px solid green'" onerror="this.style.border='1px solid red'; this.alt='FAILED TO LOAD'">
    <br><br>
    <img src="/~ks9700/iste-341/Project1/public/img/Project1_Image3.png" style="width: 200px; border: 1px solid red;" alt="Event 3" onload="this.style.border='1px solid green'" onerror="this.style.border='1px solid red'; this.alt='FAILED TO LOAD'">
    
    <h3>File Existence Check:</h3>
    <?php
    $files = [
        'public/img/Project1_LogoImage.png',
        'public/img/Project1_image1.png', 
        'public/img/Project1_Image2.png',
        'public/img/Project1_Image3.png'
    ];
    
    foreach ($files as $file) {
        echo "<p>$file: " . (file_exists($file) ? 'EXISTS' : 'MISSING') . "</p>";
    }
    ?>
    
    <h3>Directory Contents:</h3>
    <?php
    if (is_dir('public/img')) {
        echo "<p>public/img directory contents:</p><ul>";
        foreach (scandir('public/img') as $file) {
            if ($file !== '.' && $file !== '..') {
                echo "<li>$file</li>";
            }
        }
        echo "</ul>";
    } else {
        echo "<p>public/img directory does NOT exist</p>";
    }
    ?>
</body>
</html>
