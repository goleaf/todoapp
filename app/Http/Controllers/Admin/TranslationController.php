<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\Finder\Finder;

class TranslationController extends Controller
{
    protected string $langPath;

    public function __construct()
    {
        $this->langPath = base_path('lang');
    }

    /**
     * List available locales.
     */
    public function index()
    {
        $locales = $this->getLocales();
        return view('admin.translations.index', compact('locales'));
    }

    /**
     * Show files and content for a specific locale.
     */
    public function show(string $locale)
    {
        if (!$this->isValidLocale($locale)) {
            return redirect()->route('admin.translations.index')->with('error', 'Invalid locale specified.');
        }

        $files = Language::getLanguageFiles($locale);
        $filesContent = [];
        
        foreach ($files as $filename => $path) {
            $content = Language::getFileContent($locale, $filename);
            if ($content !== null) {
                $filesContent[$filename] = var_export($content, true);
            }
        }

        return view('admin.translations.show', [
            'locale' => $locale,
            'files' => $filesContent,
        ]);
    }

    /**
     * Update a specific translation file.
     */
    public function update(Request $request, string $locale, string $file)
    {
        if (!$this->isValidLocale($locale) || !preg_match('/^[a-zA-Z0-9_\-]+$/', $file)) {
             return redirect()->route('admin.translations.show', $locale)->with('error', 'Invalid locale or file name.');
        }
        
        $filePath = $this->langPath . DIRECTORY_SEPARATOR . $locale . DIRECTORY_SEPARATOR . $file . '.php';

        if (!File::exists($filePath)) {
            return redirect()->route('admin.translations.show', $locale)->with('error', 'File not found.');
        }

        $contentString = $request->input('content');

        // Basic validation: Attempt to parse the string back into PHP array
        // WARNING: Using eval is highly insecure. A safer approach would involve
        // parsing the string into an AST or using a secure config writer library.
        // This is a simplified example and NOT recommended for production.
        try {
            // Attempt to evaluate the string as PHP code to get the array
            $evaluatedContent = eval('?>' . $contentString);

            if (!is_array($evaluatedContent)) {
                 throw new \Exception('Content does not evaluate to an array.');
            }
            
            // Save the content
            Language::saveFileContent($locale, $file, $evaluatedContent);
            return redirect()->route('admin.translations.show', $locale)->with('success', "File '{$file}.php' updated successfully.");

        } catch (\Throwable $e) {
             return redirect()->back()->withInput()->with('error', 'Error processing content: ' . $e->getMessage());
        }
    }
    
    /**
     * Store a new locale (create directory).
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'locale' => ['required', 'string', 'regex:/^[a-z]{2}(?:-[A-Z]{2})?$/', Rule::notIn($this->getLocales())],
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.translations.index')->withErrors($validator)->withInput();
        }

        $locale = $request->input('locale');
        
        if (Language::createLanguage($locale)) {
            return redirect()->route('admin.translations.index')->with('success', "Locale '{$locale}' created successfully.");
        } else {
            return redirect()->route('admin.translations.index')->with('error', "Failed to create locale '{$locale}'.");
        }
    }

    /**
     * Destroy a locale (delete directory).
     */
    public function destroy(string $locale)
    {
        if (!$this->isValidLocale($locale) || $locale === 'en') { // Prevent deleting fallback locale
            return redirect()->route('admin.translations.index')->with('error', 'Invalid or fallback locale cannot be deleted.');
        }

        if (Language::deleteLanguage($locale)) {
            return redirect()->route('admin.translations.index')->with('success', "Locale '{$locale}' deleted successfully.");
        } else {
            return redirect()->route('admin.translations.index')->with('error', "Failed to delete locale '{$locale}'.");
        }
    }
    
     /**
     * Store a new translation file within a locale.
     */
    public function storeFile(Request $request, string $locale)
    {
        if (!$this->isValidLocale($locale)) {
            return redirect()->route('admin.translations.index')->with('error', 'Invalid locale specified.');
        }

        $validator = Validator::make($request->all(), [
            'filename' => ['required', 'string', 'regex:/^[a-zA-Z0-9_\-]+$/'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.translations.show', $locale)->withErrors($validator)->withInput();
        }

        $filename = $request->input('filename');
        
        // Check if file already exists
        if (File::exists($this->langPath . DIRECTORY_SEPARATOR . $locale . DIRECTORY_SEPARATOR . $filename . '.php')) {
            return redirect()->route('admin.translations.show', $locale)->with('error', "File '{$filename}.php' already exists.");
        }
        
        // Create with empty translations array
        if (Language::saveFileContent($locale, $filename, [])) {
            return redirect()->route('admin.translations.show', $locale)->with('success', "File '{$filename}.php' created successfully.");
        } else {
            return redirect()->route('admin.translations.show', $locale)->with('error', "Failed to create file '{$filename}.php'.");
        }
    }
    
    /**
     * Destroy a translation file within a locale.
     */
    public function destroyFile(string $locale, string $file)
    {
        if (!$this->isValidLocale($locale) || !preg_match('/^[a-zA-Z0-9_\-]+$/', $file)) {
            return redirect()->route('admin.translations.show', $locale)->with('error', 'Invalid locale or file name.');
        }

        $filePath = $this->langPath . DIRECTORY_SEPARATOR . $locale . DIRECTORY_SEPARATOR . $file . '.php';

        if (!File::exists($filePath)) {
            return redirect()->route('admin.translations.show', $locale)->with('error', "File '{$file}.php' not found.");
        }

        try {
            File::delete($filePath);
            return redirect()->route('admin.translations.show', $locale)->with('success', "File '{$file}.php' deleted successfully.");
        } catch (\Exception $e) {
            return redirect()->route('admin.translations.show', $locale)->with('error', 'Failed to delete file: ' . $e->getMessage());
        }
    }
    
    /**
     * Import translations from a base language.
     */
    public function import(Request $request, string $locale)
    {
        if (!$this->isValidLocale($locale)) {
            return redirect()->route('admin.translations.index')->with('error', 'Invalid locale specified.');
        }
        
        $validator = Validator::make($request->all(), [
            'source_locale' => ['required', 'string', 'regex:/^[a-z]{2}(?:-[A-Z]{2})?$/'],
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('admin.translations.show', $locale)->withErrors($validator)->withInput();
        }
        
        $sourceLocale = $request->input('source_locale');
        
        if (!$this->isValidLocale($sourceLocale)) {
            return redirect()->route('admin.translations.show', $locale)->with('error', 'Invalid source locale specified.');
        }
        
        $this->copyLocaleFiles($sourceLocale, $locale);
        
        return redirect()->route('admin.translations.show', $locale)->with('success', "Translations imported from '{$sourceLocale}' successfully.");
    }
    
    /**
     * Get all valid locales.
     *
     * @return array
     */
    protected function getLocales(): array
    {
        $languages = Language::getAvailableLanguages();
        return array_keys($languages);
    }
    
    /**
     * Check if a locale is valid.
     *
     * @param string $locale
     * @return bool
     */
    protected function isValidLocale(string $locale): bool
    {
        return preg_match('/^[a-z]{2}(?:-[A-Z]{2})?$/', $locale) && 
               File::isDirectory($this->langPath . DIRECTORY_SEPARATOR . $locale);
    }
    
    /**
     * Copy translation files from one locale to another.
     *
     * @param string $sourceLocale
     * @param string $targetLocale
     * @return void
     */
    protected function copyLocaleFiles(string $sourceLocale, string $targetLocale): void
    {
        $sourcePath = $this->langPath . DIRECTORY_SEPARATOR . $sourceLocale;
        $targetPath = $this->langPath . DIRECTORY_SEPARATOR . $targetLocale;
        
        if (!File::isDirectory($sourcePath)) {
            return;
        }
        
        if (!File::isDirectory($targetPath)) {
            File::makeDirectory($targetPath, 0755, true);
        }
        
        $files = File::files($sourcePath);
        
        foreach ($files as $file) {
            if ($file->getExtension() === 'php') {
                $filename = $file->getFilenameWithoutExtension();
                $content = include $file->getRealPath();
                
                if (is_array($content)) {
                    // If the file already exists in the target locale, preserve existing translations
                    $targetFile = $targetPath . DIRECTORY_SEPARATOR . $filename . '.php';
                    $existingContent = [];
                    
                    if (File::exists($targetFile)) {
                        $existingContent = include $targetFile;
                        if (!is_array($existingContent)) {
                            $existingContent = [];
                        }
                    }
                    
                    // Merge existing translations with source translations
                    // Existing translations take precedence
                    $merged = array_merge($content, $existingContent);
                    
                    // Mark untranslated items
                    foreach ($merged as $key => $value) {
                        if (!isset($existingContent[$key]) && isset($content[$key])) {
                            $merged[$key] = is_string($content[$key]) ? 'UNTRANSLATED: ' . $content[$key] : $content[$key];
                        }
                    }
                    
                    Language::saveFileContent($targetLocale, $filename, $merged);
                }
            }
        }
    }
    
    /**
     * Show edit form for a specific key.
     */
    public function editKey(string $locale, string $file, string $key)
    {
        if (!$this->isValidLocale($locale) || !preg_match('/^[a-zA-Z0-9_\-]+$/', $file)) {
            return redirect()->route('admin.translations.show', $locale)->with('error', 'Invalid locale or file name.');
        }
        
        $translations = Language::getFileContent($locale, $file);
        if (!is_array($translations) || !isset($translations[$key])) {
            return redirect()->route('admin.translations.show', $locale)->with('error', 'Translation key not found.');
        }
        
        // Get English version for reference (if available)
        $englishValue = null;
        if ($locale !== 'en') {
            $englishTranslations = Language::getFileContent('en', $file);
            $englishValue = $englishTranslations[$key] ?? null;
        }
        
        return view('admin.translations.edit-key', [
            'locale' => $locale,
            'file' => $file,
            'key' => $key,
            'value' => $translations[$key],
            'englishValue' => $englishValue,
        ]);
    }
    
    /**
     * Update a specific translation key.
     */
    public function updateKey(Request $request, string $locale, string $file, string $key)
    {
        if (!$this->isValidLocale($locale) || !preg_match('/^[a-zA-Z0-9_\-]+$/', $file)) {
            return redirect()->route('admin.translations.show', $locale)->with('error', 'Invalid locale or file name.');
        }
        
        $validator = Validator::make($request->all(), [
            'value' => 'required|string',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $translations = Language::getFileContent($locale, $file);
        if (!is_array($translations)) {
            return redirect()->route('admin.translations.show', $locale)->with('error', 'Translation file not found.');
        }
        
        // Update the key
        $translations[$key] = $request->input('value');
        
        if (Language::saveFileContent($locale, $file, $translations)) {
            return redirect()->route('admin.translations.show', $locale)->with('success', "Translation updated successfully.");
        } else {
            return redirect()->back()->with('error', "Failed to update translation.");
        }
    }
} 