<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Arr;

class TranslationController extends Controller
{
    protected $langPath;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->langPath = base_path('lang');
    }

    /**
     * Display a listing of available languages.
     */
    public function index()
    {
        $languages = $this->getAvailableLanguages();
        return view('admin.translations.index', compact('languages'));
    }

    /**
     * Get list of translation files for a specific language.
     */
    public function language($locale)
    {
        $languages = $this->getAvailableLanguages();
        $files = $this->getTranslationFiles($locale);
        return view('admin.translations.language', compact('locale', 'files', 'languages'));
    }

    /**
     * Show the form for editing translations of a specific file.
     */
    public function edit($locale, $file)
    {
        $languages = $this->getAvailableLanguages();
        $fileContent = $this->getTranslationFileContent($locale, $file);
        $referenceContent = $locale !== 'en' ? $this->getTranslationFileContent('en', $file) : [];
        
        // No need to flatten as we're enforcing a flat structure already
        $translations = $fileContent;
        $referenceTranslations = $referenceContent;

        return view('admin.translations.edit', compact('locale', 'file', 'translations', 'referenceTranslations', 'languages'));
    }

    /**
     * Update the translations for a specific file.
     */
    public function update(Request $request, $locale, $file)
    {
        $translations = $request->input('translations');
        
        // Ensure the directory exists
        if (!File::exists("{$this->langPath}/{$locale}")) {
            File::makeDirectory("{$this->langPath}/{$locale}", 0755, true);
        }
        
        // Save translations as PHP array - enforce flat structure
        $content = "<?php\n\nreturn " . $this->varExport($translations, true) . ";\n";
        File::put("{$this->langPath}/{$locale}/{$file}.php", $content);

        return redirect()->route('admin.translations.edit', [$locale, $file])
            ->with('success', __('messages.translations_updated'));
    }

    /**
     * Show form to create a new language.
     */
    public function createLanguage()
    {
        return view('admin.translations.create_language');
    }

    /**
     * Store a newly created language.
     */
    public function storeLanguage(Request $request)
    {
        $request->validate([
            'locale' => 'required|string|size:2|unique:languages',
            'name' => 'required|string|max:100',
        ]);

        $locale = strtolower($request->input('locale'));
        
        // Create directory for new language
        if (!File::exists("{$this->langPath}/{$locale}")) {
            File::makeDirectory("{$this->langPath}/{$locale}", 0755, true);
            
            // Copy English files as templates
            foreach (File::files("{$this->langPath}/en") as $file) {
                File::copy($file->getPathname(), "{$this->langPath}/{$locale}/" . $file->getFilename());
            }
        }

        return redirect()->route('admin.translations.language', $locale)
            ->with('success', __('messages.language_created'));
    }

    /**
     * Delete a language.
     */
    public function destroyLanguage($locale)
    {
        if ($locale !== 'en') {
            File::deleteDirectory("{$this->langPath}/{$locale}");
            return redirect()->route('admin.translations.index')
                ->with('success', __('messages.language_deleted'));
        }
        
        return redirect()->route('admin.translations.index')
            ->with('error', __('messages.cannot_delete_default_language'));
    }

    /**
     * Create a new translation file.
     */
    public function createFile($locale)
    {
        return view('admin.translations.create_file', compact('locale'));
    }

    /**
     * Store a new translation file.
     */
    public function storeFile(Request $request, $locale)
    {
        $request->validate([
            'filename' => 'required|string|max:100|regex:/^[a-zA-Z0-9_]+$/',
        ]);

        $filename = $request->input('filename');
        
        // Create empty translation file
        $content = "<?php\n\nreturn [];\n";
        File::put("{$this->langPath}/{$locale}/{$filename}.php", $content);

        return redirect()->route('admin.translations.edit', [$locale, $filename])
            ->with('success', __('messages.translation_file_created'));
    }

    /**
     * Delete a translation file.
     */
    public function destroyFile($locale, $file)
    {
        File::delete("{$this->langPath}/{$locale}/{$file}.php");
        return redirect()->route('admin.translations.language', $locale)
            ->with('success', __('messages.translation_file_deleted'));
    }

    /**
     * Get all available languages from the lang directory.
     */
    protected function getAvailableLanguages()
    {
        $languages = [];
        $directories = File::directories($this->langPath);
        
        foreach ($directories as $directory) {
            $locale = basename($directory);
            $nativeName = \Locale::getDisplayName($locale, $locale);
            $englishName = \Locale::getDisplayName($locale, 'en');
            $languages[$locale] = [
                'native' => $nativeName,
                'english' => $englishName
            ];
        }
        
        return $languages;
    }

    /**
     * Get all translation files for a given language.
     */
    protected function getTranslationFiles($locale)
    {
        $files = [];
        $path = "{$this->langPath}/{$locale}";
        
        if (File::exists($path)) {
            foreach (File::files($path) as $file) {
                if ($file->getExtension() === 'php') {
                    $files[] = $file->getFilenameWithoutExtension();
                }
            }
        }
        
        return $files;
    }

    /**
     * Get the contents of a translation file.
     */
    protected function getTranslationFileContent($locale, $file)
    {
        $path = "{$this->langPath}/{$locale}/{$file}.php";
        
        if (File::exists($path)) {
            return include $path;
        }
        
        return [];
    }

    /**
     * Custom var_export with proper formatting.
     */
    protected function varExport($expression, $return = false)
    {
        $export = var_export($expression, true);
        $export = preg_replace("/^([ ]*)(.*)/m", '$1$1$2', $export);
        $array = preg_split("/\r\n|\n|\r/", $export);
        $array = preg_replace(["/\s*array\s\($/", "/\)(,)?$/", "/\s=>\s$/"], [null, ']$1', ' => ['], $array);
        $export = implode(PHP_EOL, array_filter(["["] + $array));
        
        if ($return) {
            return $export;
        }
        
        echo $export;
    }

    /**
     * Import new keys from the English file to the target language file.
     */
    public function import(Request $request, $locale)
    {
        if ($locale === 'en') {
            return redirect()->route('admin.translations.language', $locale)
                ->with('error', __('messages.cannot_import_to_source_language'));
        }
        
        $enFiles = $this->getTranslationFiles('en');
        
        foreach ($enFiles as $file) {
            $enContent = $this->getTranslationFileContent('en', $file);
            $targetContent = $this->getTranslationFileContent($locale, $file);
            
            // Add all keys from English that don't exist in target language
            $updated = false;
            
            foreach ($enContent as $key => $value) {
                if (!isset($targetContent[$key])) {
                    $targetContent[$key] = $value;
                    $updated = true;
                }
            }
            
            if ($updated) {
                // Ensure the directory exists
                if (!File::exists("{$this->langPath}/{$locale}")) {
                    File::makeDirectory("{$this->langPath}/{$locale}", 0755, true);
                }
                
                // Save translations as PHP array
                $content = "<?php\n\nreturn " . $this->varExport($targetContent, true) . ";\n";
                File::put("{$this->langPath}/{$locale}/{$file}.php", $content);
            }
        }
        
        return redirect()->route('admin.translations.language', $locale)
            ->with('success', __('messages.translations_imported'));
    }

    /**
     * Scan blade files for translation keys.
     */
    public function scan()
    {
        $viewsPath = resource_path('views');
        $existingKeys = [];
        
        // Get all existing translation keys
        $enFiles = $this->getTranslationFiles('en');
        foreach ($enFiles as $file) {
            $content = $this->getTranslationFileContent('en', $file);
            foreach ($content as $key => $value) {
                $existingKeys["{$file}.{$key}"] = $value;
            }
        }
        
        // Scan for translation calls
        $newKeys = [];
        $this->scanDirectory($viewsPath, $newKeys);
        
        // Add new keys to corresponding files
        $updated = false;
        
        foreach ($newKeys as $fullKey => $defaultValue) {
            if (!isset($existingKeys[$fullKey])) {
                [$file, $key] = explode('.', $fullKey, 2);
                $fileContent = $this->getTranslationFileContent('en', $file);
                $fileContent[$key] = $defaultValue;
                
                // Save translations as PHP array
                $content = "<?php\n\nreturn " . $this->varExport($fileContent, true) . ";\n";
                File::put("{$this->langPath}/en/{$file}.php", $content);
                
                $updated = true;
            }
        }
        
        if ($updated) {
            return redirect()->route('admin.translations.index')
                ->with('success', __('messages.translation_keys_scanned'));
        }
        
        return redirect()->route('admin.translations.index')
            ->with('info', __('messages.no_new_translation_keys'));
    }

    /**
     * Recursively scan directory for translation calls.
     */
    protected function scanDirectory($path, &$keys)
    {
        $files = File::files($path);
        
        foreach ($files as $file) {
            if ($file->getExtension() === 'php' || $file->getExtension() === 'blade.php') {
                $content = File::get($file->getPathname());
                
                // Match __('file.key') and trans('file.key') patterns
                preg_match_all("/__\(['\"]([^'\"]+)['\"]/", $content, $matches);
                foreach ($matches[1] as $key) {
                    if (strpos($key, '.') !== false) {
                        $keys[$key] = $key;
                    }
                }
                
                preg_match_all("/trans\(['\"]([^'\"]+)['\"]/", $content, $matches);
                foreach ($matches[1] as $key) {
                    if (strpos($key, '.') !== false) {
                        $keys[$key] = $key;
                    }
                }
                
                // Match @lang('file.key') pattern
                preg_match_all("/@lang\(['\"]([^'\"]+)['\"]/", $content, $matches);
                foreach ($matches[1] as $key) {
                    if (strpos($key, '.') !== false) {
                        $keys[$key] = $key;
                    }
                }
                
                // Match {{ __('file.key') }} pattern
                preg_match_all("/\{\{\s*__\(['\"]([^'\"]+)['\"]/", $content, $matches);
                foreach ($matches[1] as $key) {
                    if (strpos($key, '.') !== false) {
                        $keys[$key] = $key;
                    }
                }
            }
        }
        
        $directories = File::directories($path);
        foreach ($directories as $directory) {
            $this->scanDirectory($directory, $keys);
        }
    }
} 