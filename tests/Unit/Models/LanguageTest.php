<?php

namespace Tests\Unit\Models;

use App\Models\Language;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class LanguageTest extends TestCase
{
    protected string $testLangPath;

    protected function setUp(): void
    {
        parent::setUp();
        $this->testLangPath = base_path('lang_test');
        // Ensure a clean state before each test
        File::deleteDirectory($this->testLangPath);
        File::makeDirectory($this->testLangPath . '/en', 0755, true);
        File::makeDirectory($this->testLangPath . '/es', 0755, true);
        
        // Mock the base_path function to point to our test directory
        $this->app->instance('path.lang', $this->testLangPath);
        Language::clearResolvedInstances(); // Clear any cached instances if needed
    }

    protected function tearDown(): void
    {
        File::deleteDirectory($this->testLangPath);
        parent::tearDown();
    }

    /** @test */
    public function it_can_get_available_languages()
    {
        // Create dummy common.php files
        File::put($this->testLangPath . '/en/common.php', "<?php return ['language_name' => 'English'];");
        File::put($this->testLangPath . '/es/common.php', "<?php return ['language_name' => 'Español'];");
        
        $languages = Language::getAvailableLanguages();
        
        $this->assertCount(2, $languages);
        $this->assertArrayHasKey('en', $languages);
        $this->assertArrayHasKey('es', $languages);
        $this->assertEquals('English', $languages['en']['name']);
        $this->assertEquals('Español', $languages['es']['name']);
    }

    /** @test */
    public function it_can_get_language_files()
    {
        File::put($this->testLangPath . '/en/common.php', '<?php return [];');
        File::put($this->testLangPath . '/en/auth.php', '<?php return [];');
        File::put($this->testLangPath . '/en/other.txt', 'not a php file'); // Should be ignored
        
        $files = Language::getLanguageFiles('en');
        
        $this->assertCount(2, $files);
        $this->assertArrayHasKey('common', $files);
        $this->assertArrayHasKey('auth', $files);
        $this->assertStringContainsString('common.php', $files['common']);
        $this->assertStringContainsString('auth.php', $files['auth']);
    }

    /** @test */
    public function it_can_get_file_content()
    {
        $contentArray = ['key1' => 'value1', 'key2' => 'value2'];
        $contentString = "<?php\n\nreturn " . var_export($contentArray, true) . ";\n";
        File::put($this->testLangPath . '/en/testfile.php', $contentString);
        
        $content = Language::getFileContent('en', 'testfile');
        
        $this->assertEquals($contentArray, $content);
    }

    /** @test */
    public function get_file_content_returns_null_for_non_existent_file()
    {
        $content = Language::getFileContent('en', 'nonexistent');
        $this->assertNull($content);
    }

    /** @test */
    public function it_can_save_file_content_and_flattens_arrays()
    {
        $nestedContent = [
            'key1' => 'value1',
            'group' => [
                'sub1' => 'subvalue1',
                'sub2' => 'subvalue2',
                'deeper' => ['deep_key' => 'deep_value'] // This should be JSON encoded
            ],
            'key3' => 'value3'
        ];
        
        $expectedFlatContent = [
            'key1' => 'value1',
            'group.sub1' => 'subvalue1',
            'group.sub2' => 'subvalue2',
            'group.deeper' => json_encode(['deep_key' => 'deep_value']),
            'key3' => 'value3'
        ];
        
        $result = Language::saveFileContent('en', 'savedfile', $nestedContent);
        $filePath = $this->testLangPath . '/en/savedfile.php';
        
        $this->assertTrue($result);
        $this->assertFileExists($filePath);
        
        $savedContent = include $filePath;
        $this->assertEquals($expectedFlatContent, $savedContent);
    }
    
    /** @test */
    public function it_creates_language_directory_and_common_file()
    {
        $result = Language::createLanguage('fr');
        $dirPath = $this->testLangPath . '/fr';
        $filePath = $dirPath . '/common.php';
        
        $this->assertTrue($result);
        $this->assertDirectoryExists($dirPath);
        $this->assertFileExists($filePath);
        
        $content = include $filePath;
        $this->assertArrayHasKey('language_name', $content);
        $this->assertEquals('Fr', $content['language_name']); // Default generated name
    }
    
    /** @test */
    public function it_deletes_language_directory()
    {
        File::makeDirectory($this->testLangPath . '/de');
        $this->assertDirectoryExists($this->testLangPath . '/de');
        
        $result = Language::deleteLanguage('de');
        
        $this->assertTrue($result);
        $this->assertDirectoryDoesNotExist($this->testLangPath . '/de');
    }
    
    /** @test */
    public function it_does_not_delete_fallback_language()
    {
        // Set fallback locale for this test
        config(['app.fallback_locale' => 'en']); 
        $this->assertDirectoryExists($this->testLangPath . '/en');
        
        $result = Language::deleteLanguage('en');
        
        $this->assertFalse($result);
        $this->assertDirectoryExists($this->testLangPath . '/en');
    }

    /** @test */
    public function flatten_array_works_correctly()
    {
        $nested = [
            'a' => 1,
            'b' => [
                'c' => 2,
                'd' => 3,
                'e' => [
                    'f' => 4
                ]
            ],
            'g' => 5
        ];
        
        $expected = [
            'a' => 1,
            'b.c' => 2,
            'b.d' => 3,
            'b.e' => json_encode(['f' => 4]),
            'g' => 5
        ];
        
        // Use reflection to test the protected method
        $reflection = new \ReflectionClass(Language::class);
        $method = $reflection->getMethod('flattenArray');
        $method->setAccessible(true);
        
        $result = $method->invoke(null, $nested);
        
        $this->assertEquals($expected, $result);
    }
} 