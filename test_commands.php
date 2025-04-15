<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Test TranslationManager command
echo "Testing TranslationManager...\n";
$translationManager = new App\Console\Commands\TranslationManager();
echo "Command signature: " . $translationManager->getSignature() . "\n";
echo "Command description: " . $translationManager->getDescription() . "\n";

// Test ComponentManager command
echo "\nTesting ComponentManager...\n";
$componentManager = new App\Console\Commands\ComponentManager();
echo "Command signature: " . $componentManager->getSignature() . "\n";
echo "Command description: " . $componentManager->getDescription() . "\n";

// Test UserManager command
echo "\nTesting UserManager...\n";
$userManager = new App\Console\Commands\UserManager();
echo "Command signature: " . $userManager->getSignature() . "\n";
echo "Command description: " . $userManager->getDescription() . "\n";

echo "\nAll commands could be instantiated successfully.\n"; 