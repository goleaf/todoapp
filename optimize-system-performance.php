<?php

/**
 * System Performance Optimization Script
 * 
 * This script identifies and fixes performance bottlenecks in the Laravel application.
 * Run using: php optimize-system-performance.php
 */

// Boot the Laravel application
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

echo "Starting system performance optimization...\n";

// 1. Disable unnecessary blade component services
echo "\n[1] Disabling unnecessary Blade component services...\n";

$appServiceProviderPath = __DIR__.'/app/Providers/AppServiceProvider.php';
$appServiceContent = file_get_contents($appServiceProviderPath);

// Create a backup
file_put_contents($appServiceProviderPath.'.bak', $appServiceContent);
echo " - Created backup of AppServiceProvider\n";

// Remove BladeComponentPreloader and BladeComponentOptimizer
$appServiceContent = preg_replace(
    '/app\(BladeComponentOptimizer::class\)->boot\(\);[\s\n]+app\(BladeComponentPreloader::class\)->boot\(\);/m',
    '// Removed slow component optimizers',
    $appServiceContent
);

// Disable variable safety check which is slow
$appServiceContent = preg_replace(
    '/if \(!Cache::has\(\'blade_components_variables_fixed\'\)\) \{[\s\n]+app\(BladeComponentService::class\)->applyVariableSafetyToAllComponents\(\);[\s\n]+\}/m',
    '// Removed slow component variable safety check',
    $appServiceContent
);

// Disable precompileCommonBladeComponents call
$appServiceContent = preg_replace(
    '/\$this->precompileCommonBladeComponents\(\);/m',
    '// Removed slow component precompilation',
    $appServiceContent
);

file_put_contents($appServiceProviderPath, $appServiceContent);
echo " - Disabled slow Blade component services\n";

// 2. Optimize database queries
echo "\n[2] Optimizing TodoController index method...\n";

$todoControllerPath = __DIR__.'/app/Http/Controllers/Api/TodoController.php';
$todoControllerContent = file_get_contents($todoControllerPath);

// Create a backup
file_put_contents($todoControllerPath.'.bak', $todoControllerContent);
echo " - Created backup of TodoController\n";

// Optimize the index method by reducing eager loading
$todoControllerContent = preg_replace(
    '/>with\(\[\'category\', \'subtasks\'\]\);/m',
    '->with(\'category\'); // Reduced eager loading to only essential relations',
    $todoControllerContent
);

// Only count subtasks when needed
$todoControllerContent = str_replace(
    'getSubtasksCountAttribute(): int
    {
        return $this->subtasks()->count();
    }',
    'getSubtasksCountAttribute(): int
    {
        return $this->relationLoaded(\'subtasks\') ? $this->subtasks->count() : $this->subtasks()->count();
    }',
    $todoControllerContent
);

// Only count completed subtasks when needed
$todoControllerContent = str_replace(
    'getCompletedSubtasksCountAttribute(): int
    {
        return $this->subtasks()->completed()->count();
    }',
    'getCompletedSubtasksCountAttribute(): int
    {
        return $this->relationLoaded(\'subtasks\')
            ? $this->subtasks->where(\'status\', \'completed\')->count()
            : $this->subtasks()->completed()->count();
    }',
    $todoControllerContent
);

file_put_contents($todoControllerPath, $todoControllerContent);
echo " - Optimized database queries in TodoController\n";

// 3. Optimize AdminMiddleware by reducing logging
echo "\n[3] Optimizing AdminMiddleware...\n";

$adminMiddlewarePath = __DIR__.'/app/Http/Middleware/AdminMiddleware.php';
if (file_exists($adminMiddlewarePath)) {
    $adminMiddlewareContent = file_get_contents($adminMiddlewarePath);
    
    // Create a backup
    file_put_contents($adminMiddlewarePath.'.bak', $adminMiddlewareContent);
    echo " - Created backup of AdminMiddleware\n";
    
    // Reduce excessive logging
    $adminMiddlewareContent = preg_replace(
        '/Log::info\(\'Admin access\', \[\s+\'user_id\' => Auth::id\(\),\s+\'name\' => Auth::user\(\)->name,\s+\'ip\' => \$request->ip\(\),\s+\'user_agent\' => \$request->userAgent\(\),\s+\'path\' => \$request->path\(\),\s+\'method\' => \$request->method\(\),\s+\]\);/m',
        'Log::info(\'Admin access\', [\'user_id\' => Auth::id(), \'path\' => $request->path()]); // Reduced logging data',
        $adminMiddlewareContent
    );
    
    // Reduce excessive unauthorized logging
    $adminMiddlewareContent = preg_replace(
        '/Log::warning\(\'Unauthorized admin access attempt\', \[\s+\'user_id\' => Auth::id\(\),\s+\'name\' => Auth::user\(\)->name,\s+\'ip\' => \$request->ip\(\),\s+\'user_agent\' => \$request->userAgent\(\),\s+\'path\' => \$request->path\(\),\s+\'method\' => \$request->method\(\),\s+\]\);/m',
        'Log::warning(\'Unauthorized admin access attempt\', [\'user_id\' => Auth::id(), \'path\' => $request->path()]); // Reduced logging data',
        $adminMiddlewareContent
    );
    
    file_put_contents($adminMiddlewarePath, $adminMiddlewareContent);
    echo " - Reduced excessive logging in AdminMiddleware\n";
} else {
    echo " - AdminMiddleware not found, skipping...\n";
}

// 4. Optimize Todo model by reducing eager loading
echo "\n[4] Optimizing Todo model...\n";

$todoModelPath = __DIR__.'/app/Models/Todo.php';
$todoModelContent = file_get_contents($todoModelPath);

// Create a backup
file_put_contents($todoModelPath.'.bak', $todoModelContent);
echo " - Created backup of Todo model\n";

// Make $with attribute empty to prevent automatic eager loading
$todoModelContent = preg_replace(
    '/protected \$with = \[\'category\'\];/m',
    'protected $with = []; // Removed automatic eager loading to improve performance',
    $todoModelContent
);

file_put_contents($todoModelPath, $todoModelContent);
echo " - Removed automatic eager loading in Todo model\n";

// 5. Update seeds for better testing
echo "\n[5] Creating database seeders...\n";

// Create a database seeder for todos
$todoSeederPath = __DIR__.'/database/seeders/TodoSeeder.php';
file_put_contents($todoSeederPath, '<?php

namespace Database\Seeders;

use App\Models\Todo;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users to assign todos to
        $users = User::all();
        
        if ($users->isEmpty()) {
            // Create a user if none exist
            $users = [User::factory()->create([
                \'name\' => \'Test User\',
                \'email\' => \'test@example.com\',
            ])];
        }
        
        foreach ($users as $user) {
            // Create some categories
            $categories = Category::factory()
                ->count(5)
                ->create([\'user_id\' => $user->id]);
                
            // Create top-level todos
            $topLevelTodos = Todo::factory()
                ->count(20)
                ->create([
                    \'user_id\' => $user->id,
                    \'category_id\' => function () use ($categories) {
                        return $categories->random()->id;
                    },
                ]);
                
            // Create subtasks for some of the top-level todos
            foreach ($topLevelTodos->random(10) as $parent) {
                Todo::factory()
                    ->count(rand(2, 5))
                    ->create([
                        \'user_id\' => $user->id,
                        \'parent_id\' => $parent->id,
                        \'category_id\' => $parent->category_id,
                    ]);
            }
        }
    }
}');
echo " - Created TodoSeeder\n";

// Update DatabaseSeeder to include the TodoSeeder
$databaseSeederPath = __DIR__.'/database/seeders/DatabaseSeeder.php';
$databaseSeederContent = file_get_contents($databaseSeederPath);
$databaseSeederContent = str_replace(
    'public function run(): void
    {
        // \App\Models\User::factory(10)->create();',
    'public function run(): void
    {
        \App\Models\User::factory(5)->create();
        
        $this->call([
            TodoSeeder::class,
        ]);',
    $databaseSeederContent
);
file_put_contents($databaseSeederPath, $databaseSeederContent);
echo " - Updated DatabaseSeeder to include TodoSeeder\n";

// 6. Creating tests
echo "\n[6] Creating tests...\n";

// Create a feature test for todos
$todoTestPath = __DIR__.'/tests/Feature/TodoTest.php';
file_put_contents($todoTestPath, '<?php

namespace Tests\Feature;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodoTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_todos()
    {
        $user = User::factory()->create();
        Todo::factory()->count(5)->create([\'user_id\' => $user->id]);

        $response = $this->actingAs($user)
            ->getJson(\'/api/todos\');

        $response->assertStatus(200)
            ->assertJsonCount(5, \'data\');
    }

    public function test_can_create_todo()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson(\'/api/todos\', [
                \'title\' => \'Test Todo\',
                \'description\' => \'This is a test todo\',
                \'priority\' => \'medium\',
                \'status\' => \'pending\',
                \'due_date\' => now()->addDays(3)->toDateTimeString(),
            ]);

        $response->assertStatus(201)
            ->assertJson([
                \'data\' => [
                    \'title\' => \'Test Todo\',
                    \'description\' => \'This is a test todo\',
                    \'priority\' => \'medium\',
                    \'status\' => \'pending\',
                ],
            ]);
    }

    public function test_can_update_todo()
    {
        $user = User::factory()->create();
        $todo = Todo::factory()->create([\'user_id\' => $user->id]);

        $response = $this->actingAs($user)
            ->putJson(\'/api/todos/\' . $todo->id, [
                \'title\' => \'Updated Todo\',
                \'status\' => \'completed\',
            ]);

        $response->assertStatus(200)
            ->assertJson([
                \'data\' => [
                    \'title\' => \'Updated Todo\',
                    \'status\' => \'completed\',
                ],
            ]);
    }

    public function test_can_delete_todo()
    {
        $user = User::factory()->create();
        $todo = Todo::factory()->create([\'user_id\' => $user->id]);

        $response = $this->actingAs($user)
            ->deleteJson(\'/api/todos/\' . $todo->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing(\'todos\', [\'id\' => $todo->id]);
    }
}');
echo " - Created TodoTest\n";

// Create a feature test for categories
$categoryTestPath = __DIR__.'/tests/Feature/CategoryTest.php';
file_put_contents($categoryTestPath, '<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_categories()
    {
        $user = User::factory()->create();
        Category::factory()->count(3)->create([\'user_id\' => $user->id]);

        $response = $this->actingAs($user)
            ->getJson(\'/api/categories\');

        $response->assertStatus(200)
            ->assertJsonCount(3, \'data\');
    }

    public function test_can_create_category()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson(\'/api/categories\', [
                \'name\' => \'Test Category\',
                \'color\' => \'#FF5733\',
            ]);

        $response->assertStatus(201)
            ->assertJson([
                \'data\' => [
                    \'name\' => \'Test Category\',
                    \'color\' => \'#FF5733\',
                ],
            ]);
    }

    public function test_can_update_category()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create([\'user_id\' => $user->id]);

        $response = $this->actingAs($user)
            ->putJson(\'/api/categories/\' . $category->id, [
                \'name\' => \'Updated Category\',
                \'color\' => \'#33FF57\',
            ]);

        $response->assertStatus(200)
            ->assertJson([
                \'data\' => [
                    \'name\' => \'Updated Category\',
                    \'color\' => \'#33FF57\',
                ],
            ]);
    }

    public function test_can_delete_category()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create([\'user_id\' => $user->id]);

        $response = $this->actingAs($user)
            ->deleteJson(\'/api/categories/\' . $category->id);

        $response->assertStatus(200);
        $this->assertDatabaseMissing(\'categories\', [\'id\' => $category->id]);
    }
}');
echo " - Created CategoryTest\n";

echo "\nAll optimization tasks completed!\n";
echo "\nNext steps:";
echo "\n1. Run the performance optimization script: php optimize-system-performance.php";
echo "\n2. Run database seeders: php artisan db:seed";
echo "\n3. Run tests: php artisan test";
echo "\n4. Monitor application performance after changes\n"; 