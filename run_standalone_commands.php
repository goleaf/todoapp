<?php

// This script runs our commands directly without relying on Laravel's Artisan system

// Define constant for success return code
const SUCCESS = 0;
const FAILURE = 1;

// Simple mock command class that our commands will extend
class Command {
    protected $signature = '';
    protected $description = '';
    
    public function info($message) {
        echo "\033[32m{$message}\033[0m\n";
    }
    
    public function error($message) {
        echo "\033[31m{$message}\033[0m\n";
        return FAILURE;
    }
    
    public function warn($message) {
        echo "\033[33m{$message}\033[0m\n";
    }
    
    public function line($message) {
        echo "{$message}\n";
    }
    
    public function table($headers, $rows) {
        // Simple table output
        echo implode("\t", $headers) . "\n";
        echo str_repeat('-', 80) . "\n";
        foreach ($rows as $row) {
            echo implode("\t", $row) . "\n";
        }
        echo "\n";
    }
    
    public function getSignature() {
        return $this->signature ?? 'No signature defined';
    }
    
    public function getDescription() {
        return $this->description ?? 'No description defined';
    }
    
    public function argument($key) {
        global $argv;
        if ($key === 'action') {
            return $argv[2] ?? 'list'; // Default action
        }
        return null;
    }
    
    public function option($key) {
        global $argv;
        $options = [];
        
        // Parse command line options (--option or --option=value)
        for ($i = 3; $i < count($argv); $i++) {
            if (strpos($argv[$i], '--') === 0) {
                $option = substr($argv[$i], 2);
                $parts = explode('=', $option);
                
                if (count($parts) === 2) {
                    $options[$parts[0]] = $parts[1];
                } else {
                    $options[$parts[0]] = 'true';
                }
            }
        }
        
        return $options[$key] ?? null;
    }
    
    public function ask($question) {
        echo "{$question}: ";
        return trim(fgets(STDIN));
    }
    
    public function secret($question) {
        echo "{$question}: ";
        return trim(fgets(STDIN));
    }
    
    public function choice($question, $choices, $default) {
        echo "{$question} [" . implode(', ', $choices) . "]: ";
        return trim(fgets(STDIN)) ?: $choices[$default];
    }
}

// Helper functions
function base_path($path = '') {
    return __DIR__ . ($path ? '/' . $path : '');
}

function resource_path($path = '') {
    return __DIR__ . '/resources' . ($path ? '/' . $path : '');
}

// Mock dependencies
class File {
    public static function exists($path) {
        return file_exists($path);
    }
    
    public static function get($path) {
        return file_exists($path) ? file_get_contents($path) : null;
    }
    
    public static function put($path, $content) {
        return file_put_contents($path, $content);
    }
    
    public static function makeDirectory($path, $mode = 0755, $recursive = false) {
        return mkdir($path, $mode, $recursive);
    }
    
    public static function directories($path) {
        $dirs = [];
        foreach (glob($path . '/*', GLOB_ONLYDIR) as $dir) {
            $dirs[] = $dir;
        }
        return $dirs;
    }
    
    public static function files($path) {
        return glob($path . '/*');
    }
}

class Finder {
    protected $paths = [];
    protected $names = [];
    
    public function files() {
        return $this;
    }
    
    public function in($path) {
        $this->paths[] = $path;
        return $this;
    }
    
    public function name($pattern) {
        $this->names[] = $pattern;
        return $this;
    }
    
    // Iterator implementation to allow foreach loops
    public function getIterator() {
        $files = [];
        foreach ($this->paths as $path) {
            foreach ($this->names as $pattern) {
                $matches = glob($path . '/' . $pattern);
                foreach ($matches as $match) {
                    $files[] = new class($match) {
                        private $path;
                        
                        public function __construct($path) {
                            $this->path = $path;
                        }
                        
                        public function getRealPath() {
                            return $this->path;
                        }
                    };
                }
            }
        }
        return new ArrayIterator($files);
    }
}

class User {
    public $id;
    public $name;
    public $email;
    public $is_admin;
    public $created_at;
    public $password;
    
    public function save() {
        echo "[MOCK] Saving user {$this->name}...\n";
        return true;
    }
    
    public static function where($field, $value) {
        return new class {
            public function first() {
                $user = new User();
                $user->id = 1;
                $user->name = 'Test User';
                $user->email = 'test@example.com';
                $user->is_admin = false;
                $user->created_at = new DateTime();
                return $user;
            }
            
            public function exists() {
                return false;
            }
        };
    }
    
    public static function all($fields = []) {
        $users = [];
        
        $user1 = new User();
        $user1->id = 1;
        $user1->name = 'Admin User';
        $user1->email = 'admin@example.com';
        $user1->is_admin = true;
        $user1->created_at = new DateTime();
        
        $user2 = new User();
        $user2->id = 2;
        $user2->name = 'Regular User';
        $user2->email = 'user@example.com';
        $user2->is_admin = false;
        $user2->created_at = new DateTime();
        
        $users[] = $user1;
        $users[] = $user2;
        
        return $users;
    }
}

class Hash {
    public static function make($value) {
        return password_hash($value, PASSWORD_DEFAULT);
    }
}

// Register namespaces for our command classes
namespace App\Console\Commands {
    class TranslationManager extends \Command {}
    class ComponentManager extends \Command {}
    class UserManager extends \Command {}
}

// Namespace for Models
namespace App\Models {
    class User extends \User {}
}

// Set up aliases for Laravel facade classes
class_alias('File', 'Illuminate\\Support\\Facades\\File');
class_alias('Finder', 'Symfony\\Component\\Finder\\Finder');

// Back to global namespace
namespace {

// Main function to run the selected command
function runCommand() {
    echo "===== DIRECT COMMAND EXECUTION TEST =====\n\n";
    
    // Include autoloader
    require __DIR__ . '/vendor/autoload.php';
    
    // Define command mapping
    $commandFiles = [
        'translations' => ['class' => 'App\Console\Commands\TranslationManager', 'file' => 'app/Console/Commands/TranslationManager.php'],
        'components' => ['class' => 'App\Console\Commands\ComponentManager', 'file' => 'app/Console/Commands/ComponentManager.php'],
        'user' => ['class' => 'App\Console\Commands\UserManager', 'file' => 'app/Console/Commands/UserManager.php']
    ];
    
    // Parse command line arguments
    global $argv;
    $selectedCommand = $argv[1] ?? 'help';
    $action = $argv[2] ?? 'list';
    
    if ($selectedCommand == 'help' || !isset($commandFiles[$selectedCommand])) {
        echo "Usage: php run_standalone_commands.php <command> <action> [options]\n\n";
        echo "Available commands:\n";
        foreach ($commandFiles as $command => $info) {
            echo "  {$command}\n";
        }
        echo "\nFor example:\n";
        echo "  php run_standalone_commands.php translations report\n";
        echo "  php run_standalone_commands.php components list\n";
        echo "  php run_standalone_commands.php user list\n";
        return 0;
    }
    
    // Load the selected command code
    $commandInfo = $commandFiles[$selectedCommand];
    $commandFile = $commandInfo['file'];
    $commandClass = $commandInfo['class'];
    
    echo "Running {$commandClass} with action: {$action}\n\n";
    
    // Include the command file code
    $commandCode = file_get_contents($commandFile);
    
    // Extract the class definition
    preg_match('/class\s+(\w+)\s+extends\s+Command\s*{(.+?)}/s', $commandCode, $matches);
    
    if (empty($matches)) {
        echo "Error: Could not extract command class from {$commandFile}\n";
        return 1;
    }
    
    $className = $matches[1];
    $classBody = $matches[2];
    
    // Extract signature and description
    preg_match('/protected\s+\$signature\s*=\s*[\'"]([^\'"]+)/i', $classBody, $signatureMatch);
    preg_match('/protected\s+\$description\s*=\s*[\'"]([^\'"]+)/i', $classBody, $descriptionMatch);
    
    $signature = $signatureMatch[1] ?? null;
    $description = $descriptionMatch[1] ?? null;
    
    // Create a dynamic class with the extracted properties
    eval("
    namespace App\\Console\\Commands {
        class {$className} extends \\Command {
            protected \$signature = '{$signature}';
            protected \$description = '{$description}';
            
            {$classBody}
        }
    }
    ");
    
    // Create an instance of the command
    $command = new $commandClass();
    
    // Execute the handle method
    try {
        $result = $command->handle();
        echo "\nCommand execution completed with code: " . ($result ?? 'unknown') . "\n";
        return $result ?? 0;
    } catch (\Exception $e) {
        echo "\nError executing command: " . $e->getMessage() . "\n";
        echo $e->getTraceAsString() . "\n";
        return 1;
    }
}

// Execute the main function
exit(runCommand());

} 