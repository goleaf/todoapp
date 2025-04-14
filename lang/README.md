# Translation Management

This application supports multiple languages through Laravel's localization system. The translation files are stored in the `lang` directory, organized by language code.

## Supported Languages

- English (en) - Base language
- French (fr)
- Spanish (es)
- German (de)
- Italian (it)
- Russian (ru)
- Japanese (ja)
- Chinese (zh)
- Lithuanian (lt)

## Directory Structure

Each language directory contains multiple PHP files, each responsible for a specific section of the application:

```
lang/
├── en/
│   ├── accessibility.php
│   ├── auth.php
│   ├── common.php
│   ├── messages.php
│   ├── todo.php
│   └── ...
├── fr/
│   ├── auth.php
│   ├── common.php
│   └── ...
└── ...
```

## Translation Commands

The application provides several commands to help manage translations:

### 1. Find Untranslated Strings

Identifies untranslated strings across all language files.

```bash
php artisan translations:find-untranslated [--language=all]
```

Options:
- `--language`: Specify a language code to check (default: all)

### 2. Create Missing Translations

Creates missing translation files and adds untranslated keys.

```bash
php artisan translations:create-missing [--language=all] [--mark-untranslated]
```

Options:
- `--language`: Specify a language code to update (default: all)
- `--mark-untranslated`: Mark untranslated strings with "UNTRANSLATED:" prefix

### 3. Translate Untranslated Strings

Automatically translates strings marked as untranslated using Google Translate API.

```bash
php artisan translations:translate --api-key=YOUR_API_KEY [--language=all] [--delay=1] [--max-strings=100]
```

Options:
- `--api-key`: Your Google Translate API key (required)
- `--language`: Specify a language code to translate (default: all)
- `--delay`: Delay between API requests in seconds (default: 1)
- `--max-strings`: Maximum number of strings to translate per language (default: 100)

### 4. Generate Translation Report

Generates a report on translation completeness for all languages.

```bash
php artisan translations:report [--output=path/to/report.json]
```

Options:
- `--output`: Path to save the report as JSON

## Translation Process

1. First, run the find untranslated strings command to see what's missing:
   ```bash
   php artisan translations:find-untranslated
   ```

2. Create missing translation files and mark untranslated strings:
   ```bash
   php artisan translations:create-missing --mark-untranslated
   ```

3. (Optional) Automatically translate untranslated strings:
   ```bash
   php artisan translations:translate --api-key=YOUR_API_KEY
   ```

4. Generate a report to check translation progress:
   ```bash
   php artisan translations:report --output=translation-report.json
   ```

## Translation Usage

### In Blade Templates

Use the `__()` helper to translate strings:

```blade
<h1>{{ __('welcome.title') }}</h1>
<p>{{ __('welcome.description') }}</p>
```

### In Controllers or PHP Files

```php
$message = __('messages.welcome');
```

### With Parameters

```php
// In translation file:
// 'greeting' => 'Hello, :name!'

echo __('messages.greeting', ['name' => 'John']);
// Output: Hello, John!
```

## Adding a New Language

To add a new language:

1. Run the create missing translations command with the new language code:
   ```bash
   php artisan translations:create-missing --language=pl
   ```

2. This will create all required translation files with untranslated strings.

3. You can then translate these strings manually or using the translate command.

## Translation Guidelines

1. Don't translate placeholder variables like `:attribute` or `{variable}`
2. Maintain the same HTML formatting in translated strings
3. Pay attention to pluralization rules for different languages

## Admin Translation Management

As an administrator, you can manage translations through the admin interface:

1. Go to Admin → Translations
2. From there you can:
   - Add or remove languages
   - Add, edit, or delete translation files
   - Edit translation strings for each language

## User Language Selection

Users can change their language preference in two ways:

1. Use the language dropdown in the navigation bar
2. Go to Settings → Language to set their preferred language 

## Verification

After translating, verify that all strings appear correctly in the application by switching to each language in the settings. 