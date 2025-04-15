<?php

// This script checks if the command files are syntactically correct
// without relying on Laravel's service container

$commandFiles = [
    'app/Console/Commands/TranslationManager.php',
    'app/Console/Commands/ComponentManager.php',
    'app/Console/Commands/UserManager.php'
];

foreach ($commandFiles as $file) {
    echo "Checking {$file}... ";
    
    // Use PHP's built-in syntax checking
    $output = [];
    $exitCode = 0;
    exec("php -l {$file}", $output, $exitCode);
    
    if ($exitCode === 0) {
        echo "PASS\n";
        echo "Content summary:\n";
        
        // Check for expected patterns in the file
        $content = file_get_contents($file);
        preg_match('/class\s+(\w+)\s+extends\s+Command/i', $content, $classMatch);
        preg_match('/protected\s+\$signature\s*=\s*[\'"]([^\'"]+)/i', $content, $signatureMatch);
        preg_match('/protected\s+\$description\s*=\s*[\'"]([^\'"]+)/i', $content, $descriptionMatch);
        
        echo "  Class: " . ($classMatch[1] ?? 'Not found') . "\n";
        echo "  Signature: " . ($signatureMatch[1] ?? 'Not found') . "\n";
        echo "  Description: " . ($descriptionMatch[1] ?? 'Not found') . "\n";
        
        // Count methods
        preg_match_all('/protected\s+function\s+(\w+)/i', $content, $methodMatches);
        if (!empty($methodMatches[1])) {
            echo "  Methods: " . count($methodMatches[1]) . " found\n";
            echo "    " . implode(", ", $methodMatches[1]) . "\n";
        } else {
            echo "  Methods: None found\n";
        }
    } else {
        echo "FAIL\n";
        echo implode("\n", $output) . "\n";
    }
    
    echo "\n";
}

echo "Command file syntax check completed.\n"; 