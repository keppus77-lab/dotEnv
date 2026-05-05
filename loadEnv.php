<?php
function loadEnv($path) {
    if (!file_exists($path)) {
        throw new Exception('.env file not found');
    }
    
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Kommentare Überspringen
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        
        // KEY=VALUE parsen
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);
        
        // Anführungszeichen entfernen
        $value = trim($value, '"\'');
        
        // In $_ENV und $_SERVER setzen
        $_ENV[$name] = $value;
        $_SERVER[$name] = $value;
        putenv("$name=$value");
    }
}

// Verwenden


