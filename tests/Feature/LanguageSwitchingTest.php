<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Language;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Tests\TestCase;
use Illuminate\Support\Facades\Session;

class LanguageSwitchingTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected string $testLangPath;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);

        $this->testLangPath = base_path('lang_test');
        File::deleteDirectory($this->testLangPath);
        File::makeDirectory($this->testLangPath . '/en', 0755, true);
        File::makeDirectory($this->testLangPath . '/es', 0755, true);
        File::put($this->testLangPath . '/en/common.php', "<?php return ['language_name' => 'English'];");
        File::put($this->testLangPath . '/es/common.php', "<?php return ['language_name' => 'Español'];");
        
        // Mock the path
        $this->app->instance('path.lang', $this->testLangPath);
        Language::clearResolvedInstances();
        
        // Set fallback for tests
        config(['app.fallback_locale' => 'en']);
        config(['app.locale' => 'en']);
        Session::put('locale', 'en'); // Start with EN
    }

    protected function tearDown(): void
    {
        File::deleteDirectory($this->testLangPath);
        parent::tearDown();
    }

    /** @test */
    public function user_can_switch_language_via_route()
    {
        $response = $this->get(route('language.switch', 'es'));

        $response->assertRedirect(); // Should redirect back
        $this->assertEquals('es', Session::get('locale'));
        $this->assertEquals('es', app()->getLocale());
    }
    
    /** @test */
    public function switching_to_invalid_language_falls_back_to_default()
    {
        $response = $this->get(route('language.switch', 'invalid'));

        $response->assertRedirect();
        $this->assertEquals('en', Session::get('locale'));
        $this->assertEquals('en', app()->getLocale());
    }

    /** @test */
    public function middleware_sets_locale_from_session()
    {
        Session::put('locale', 'es');
        
        // Make a request to any route protected by the 'web' middleware group (which includes SetLocale)
        $this->get(route('dashboard'))->assertOk(); 
        
        $this->assertEquals('es', app()->getLocale());
    }

    /** @test */
    public function user_can_view_language_settings_page()
    {
        $response = $this->get(route('settings.language.edit'));

        $response->assertOk();
        $response->assertViewIs('settings.language');
        $response->assertSee('English');
        $response->assertSee('Español');
        $response->assertViewHas('currentLocale', 'en');
    }

    /** @test */
    public function user_can_update_language_preference_in_settings()
    {
        $response = $this->put(route('settings.language.update'), ['locale' => 'es']);

        $response->assertRedirect(route('settings.language.edit'));
        $response->assertSessionHas('success');
        $this->assertEquals('es', Session::get('locale'));
    }
    
    /** @test */
    public function user_cannot_update_to_invalid_language_in_settings()
    {
        $response = $this->put(route('settings.language.update'), ['locale' => 'invalid']);

        $response->assertRedirect(); // Redirects back
        $response->assertSessionHasErrors('locale');
        $this->assertEquals('en', Session::get('locale')); // Should remain 'en'
    }
} 