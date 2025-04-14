# Translation System

This directory contains the translation files for the application. Each language has its own directory with PHP files containing translation strings.

## Directory Structure

```
lang/
├── en/           # English translations (base language)
├── fr/           # French translations
├── es/           # Spanish translations
├── de/           # German translations
├── ...           # Other languages
```

## Adding a New Language

1. Create a new folder with the language code (e.g., `it` for Italian)
2. At minimum, create a `common.php` file with the language name:

```php
<?php

return [
    // Language Name (Self-referential)
    'language_name' => 'Italiano',
];
```

3. Copy other PHP files from the `en` directory and translate the values

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

### Language Files

Each translation file should return an array of key-value pairs. The structure should be the same across all languages. Values in the array are what get translated, keys should remain the same.

Example (`en/welcome.php`):
```php
<?php

return [
    'title' => 'Welcome to our application',
    'description' => 'This is a sample application',
];
```

Corresponding French translation (`fr/welcome.php`):
```php
<?php

return [
    'title' => 'Bienvenue dans notre application',
    'description' => "C'est une application d'exemple",
];
```

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