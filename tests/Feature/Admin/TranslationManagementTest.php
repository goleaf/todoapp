<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Language;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class TranslationManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;
    protected string $testLangPath;

    protected function setUp(): void
    {
        parent::setUp();
        $this->adminUser = User::factory()->create(['is_admin' => 1]);
        $this->actingAs($this->adminUser);

        $this->testLangPath = base_path('lang_test');
        // Clean and setup test lang directory
        File::deleteDirectory($this->testLangPath);
        File::makeDirectory($this->testLangPath . '/en', 0755, true);
        File::put($this->testLangPath . '/en/common.php', "<?php return ['language_name' => 'English', 'test_key' => 'Test Value EN'];");
        
        // Mock the base_path for Language model
        $this->app->instance('path.lang', $this->testLangPath);
        Language::clearResolvedInstances();
        // Set fallback for tests
        config(['app.fallback_locale' => 'en']);
    }

    protected function tearDown(): void
    {
        File::deleteDirectory($this->testLangPath);
        parent::tearDown();
    }

    /** @test */
    public function admin_can_view_translation_index()
    {
        $response = $this->get(route('admin.translations.index'));
        $response->assertOk();
        $response->assertViewIs('admin.translations.index');
        $response->assertSee('English');
    }

    /** @test */
    public function admin_can_view_specific_locale_translations()
    {
        $response = $this->get(route('admin.translations.show', 'en'));
        $response->assertOk();
        $response->assertViewIs('admin.translations.show');
        $response->assertSee('common.php');
        $response->assertSee('test_key');
    }
    
    /** @test */
    public function admin_can_add_new_locale()
    {
        $response = $this->post(route('admin.translations.store'), ['locale' => 'fr']);
        $response->assertRedirect(route('admin.translations.index'));
        $response->assertSessionHas('success');
        $this->assertDirectoryExists($this->testLangPath . '/fr');
        $this->assertFileExists($this->testLangPath . '/fr/common.php');
    }
    
    /** @test */
    public function admin_cannot_add_invalid_locale()
    {
        $response = $this->post(route('admin.translations.store'), ['locale' => 'invalid-']);
        $response->assertRedirect(route('admin.translations.index'));
        $response->assertSessionHasErrors('locale');
        $this->assertDirectoryDoesNotExist($this->testLangPath . '/invalid-');
    }
    
    /** @test */
    public function admin_can_delete_locale()
    {
        Language::createLanguage('de');
        $this->assertDirectoryExists($this->testLangPath . '/de');
        
        $response = $this->delete(route('admin.translations.destroy', 'de'));
        $response->assertRedirect(route('admin.translations.index'));
        $response->assertSessionHas('success');
        $this->assertDirectoryDoesNotExist($this->testLangPath . '/de');
    }
    
    /** @test */
    public function admin_cannot_delete_fallback_locale()
    {
        $response = $this->delete(route('admin.translations.destroy', 'en'));
        $response->assertRedirect(route('admin.translations.index'));
        $response->assertSessionHas('error'); // Should have error message
        $this->assertDirectoryExists($this->testLangPath . '/en');
    }
    
    /** @test */
    public function admin_can_add_new_file_to_locale()
    {
        $response = $this->post(route('admin.translations.file.store', 'en'), ['filename' => 'auth']);
        $response->assertRedirect(route('admin.translations.show', 'en'));
        $response->assertSessionHas('success');
        $this->assertFileExists($this->testLangPath . '/en/auth.php');
        $content = include $this->testLangPath . '/en/auth.php';
        $this->assertEquals([], $content); // Should be an empty array
    }
    
    /** @test */
    public function admin_can_delete_file_from_locale()
    {
        File::put($this->testLangPath . '/en/temp.php', '<?php return [];');
        $this->assertFileExists($this->testLangPath . '/en/temp.php');
        
        $response = $this->delete(route('admin.translations.file.destroy', ['locale' => 'en', 'file' => 'temp']));
        $response->assertRedirect(route('admin.translations.show', 'en'));
        $response->assertSessionHas('success');
        $this->assertFileDoesNotExist($this->testLangPath . '/en/temp.php');
    }
    
    /** @test */
    public function admin_can_view_edit_key_page()
    {
        $response = $this->get(route('admin.translations.key.edit', ['locale' => 'en', 'file' => 'common', 'key' => 'test_key']));
        $response->assertOk();
        $response->assertViewIs('admin.translations.edit-key');
        $response->assertSee('Test Value EN');
    }
    
    /** @test */
    public function admin_can_update_translation_key()
    {
        $newValue = 'Updated Test Value EN';
        $response = $this->put(route('admin.translations.key.update', ['locale' => 'en', 'file' => 'common', 'key' => 'test_key']), [
            'value' => $newValue
        ]);
        
        $response->assertRedirect(route('admin.translations.show', 'en'));
        $response->assertSessionHas('success');
        
        $content = Language::getFileContent('en', 'common');
        $this->assertEquals($newValue, $content['test_key']);
    }
    
    /** @test */
    public function regular_user_cannot_access_admin_translation_routes()
    {
        $user = User::factory()->create(['is_admin' => 0]);
        $this->actingAs($user);
        
        $response = $this->get(route('admin.translations.index'));
        $response->assertStatus(403); // Forbidden
        
        $response = $this->get(route('admin.translations.show', 'en'));
        $response->assertStatus(403);
        
        $response = $this->post(route('admin.translations.store'), ['locale' => 'fr']);
        $response->assertStatus(403);
    }
} 