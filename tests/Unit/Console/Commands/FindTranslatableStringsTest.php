<?php

namespace Tests\Unit\Console\Commands;

use Illuminate\Support\Facades\File;
use Tests\TestCase;

class FindTranslatableStringsTest extends TestCase
{
    protected string $testViewPath;
    protected string $testAppPath;
    protected string $testLangPath;

    protected function setUp(): void
    {
        parent::setUp();
        $this->testViewPath = resource_path('views_test');
        $this->testAppPath = app_path('app_test');
        $this->testLangPath = base_path('lang_test');

        // Cleanup and setup test directories
        File::deleteDirectory($this->testViewPath);
        File::deleteDirectory($this->testAppPath);
        File::deleteDirectory($this->testLangPath);
        File::makeDirectory($this->testViewPath . '/subdir', 0755, true);
        File::makeDirectory($this->testAppPath . '/Http/Controllers', 0755, true);
        File::makeDirectory($this->testLangPath . '/en', 0755, true);
        
        // Mock paths
        $this->app->instance('path.resources', dirname($this->testViewPath)); // Point to parent of views_test
        $this->app->instance('path.app', $this->testAppPath);
        $this->app->instance('path.lang', $this->testLangPath);
    }

    protected function tearDown(): void
    {
        File::deleteDirectory($this->testViewPath);
        File::deleteDirectory($this->testAppPath);
        File::deleteDirectory($this->testLangPath);
        parent::tearDown();
    }

    /** @test */
    public function it_finds_hardcoded_strings_in_blade_files()
    {
        $bladeContent = <<<BLADE
        <div>
            <h1>{{ __('already.translated') }}</h1>
            <p>This is a hardcoded string with punctuation!</p>
            <p>Short string</p> {{-- Should be ignored --}}
            <button>Click Me Please</button>
            <a href="#" title="{{ $variable }}">{{ trans('another.key', ['p' => 1]) }}</a>
            <input placeholder="Enter your name here.">
            @lang('foo.bar')
            <p class="{{ $class }}">Don't translate 'this' part.</p>
        </div>
        BLADE;
        File::put($this->testViewPath . '/test.blade.php', $bladeContent);

        $this->artisan('translations:find')
            ->expectsOutputContaining('This is a hardcoded string with punctuation!')
            ->expectsOutputContaining('Click Me Please')
            ->expectsOutputContaining('Enter your name here.')
            ->doesntExpectOutputContaining('Short string')
            ->doesntExpectOutputContaining('already.translated')
            ->doesntExpectOutputContaining('another.key')
            ->doesntExpectOutputContaining('foo.bar')
            ->expectsOutput('Found 3 potentially hardcoded strings:')
            ->assertExitCode(0);
    }
    
    /** @test */
    public function it_finds_hardcoded_strings_in_php_files()
    {
        $phpContent = <<<PHP
        <?php
        namespace App\Http\Controllers;
        class TestController {
            public function index() {
                $message1 = __('translated.message');
                return response()->json(['message' => 'Operation was successful.']);
            }
            public function store() {
                echo "Data saved correctly!";
                Session::flash('status', 'Profile updated!');
                throw new \Exception('Something went wrong, please try again.');
            }
        }
        PHP;
        File::put($this->testAppPath . '/Http/Controllers/TestController.php', $phpContent);
        
        $this->artisan('translations:find')
            ->expectsOutputContaining('Operation was successful')
            ->expectsOutputContaining('Data saved correctly!')
            ->expectsOutputContaining('Profile updated!')
            ->expectsOutputContaining('Something went wrong, please try again')
            ->doesntExpectOutputContaining('translated.message')
            ->expectsOutput('Found 4 potentially hardcoded strings:')
            ->assertExitCode(0);
    }
    
    /** @test */
    public function it_exports_found_strings_to_file()
    {
        $bladeContent = '<p>Export this string please.</p>';
        $phpContent = '<?php return [\'message\' => "And export this one too, okay?"];';
        File::put($this->testViewPath . '/export.blade.php', $bladeContent);
        File::put($this->testAppPath . '/ExportModel.php', $phpContent);
        
        $exportFilePath = $this->testLangPath . '/en/export_test.php';
        File::delete($exportFilePath); // Ensure it doesn't exist
        
        $this->artisan('translations:find --export=export_test')
             ->expectsOutputContaining("Exported 2 translations to $exportFilePath")
             ->assertExitCode(0);
            
        $this->assertFileExists($exportFilePath);
        $translations = include $exportFilePath;
        
        $this->assertCount(2, $translations);
        $this->assertArrayHasKey('export_this_string_please', $translations);
        $this->assertEquals('Export this string please.', $translations['export_this_string_please']);
        $this->assertArrayHasKey('and_export_this_one_too_okay', $translations);
        $this->assertEquals('And export this one too, okay?', $translations['and_export_this_one_too_okay']);
    }
    
    /** @test */
    public function it_merges_with_existing_export_file()
    {
        $bladeContent = '<p>New string for export.</p>';
        File::put($this->testViewPath . '/merge.blade.php', $bladeContent);
        
        $exportFilePath = $this->testLangPath . '/en/merge_test.php';
        $existingContent = ['existing_key' => 'Existing Value'];
        $contentString = "<?php\n\nreturn " . var_export($existingContent, true) . ";\n";
        File::put($exportFilePath, $contentString);
        
        $this->artisan('translations:find --export=merge_test')
             ->assertExitCode(0);
            
        $translations = include $exportFilePath;
        $this->assertCount(2, $translations);
        $this->assertArrayHasKey('existing_key', $translations);
        $this->assertArrayHasKey('new_string_for_export', $translations);
        $this->assertEquals('New string for export.', $translations['new_string_for_export']);
    }
} 