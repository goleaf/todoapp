<?php

return [
    // Translation Management Section
    'translations' => 'Translations',
    'page_title' => 'Manage Translations',
    'edit_locale_page_title' => 'Edit Locale :locale | Translations',
    'editing_locale_heading' => 'Editing :locale (:name)',
    'new_locale_placeholder' => 'Enter locale code (e.g., es)',
    'new_locale_title' => 'Locale code, e.g., en, es, fr-CA',
    'add_locale_button' => 'Add Locale',
    'no_locales_title' => 'No Languages Found',
    'no_locales_desc' => 'Add your first language to start managing translations.',
    'locale_code' => 'Locale Code',
    'language_name' => 'Language Name',
    'actions' => 'Actions',
    'edit_button' => 'Edit Files',
    'delete_button' => 'Delete',
    'delete_locale_confirm' => 'Are you sure you want to delete the locale \':locale\' and all its files? This cannot be undone.',
    'back_to_list' => 'Back to Locales',
    'add_file_button' => 'Add File',
    'new_file_placeholder' => 'Enter filename (no .php)',
    'new_file_title' => 'Filename (e.g., validation, messages)',
    'no_files_title' => 'No Translation Files Found',
    'no_files_desc' => 'Add your first translation file for this locale.',
    'save_file_button' => 'Save File',
    'delete_file_confirm' => 'Are you sure you want to delete the file \':file.php\'? This cannot be undone.',
    
    // Keys for enhanced translation management
    'key' => 'Key',
    'value' => 'Value',
    'edit_key' => 'Edit',
    'no_translations' => 'No translations found in this file.',
    'nested_array' => 'Nested Array',
    'edit_key_title' => 'Edit Translation Key - :key | :file',
    'editing_key_heading' => 'Editing key ":key" in :file',
    'back_to_translations' => 'Back to Translations',
    'translation_value' => 'Translation',
    'save_translations' => 'Save Translations',
    'nested_value_warning' => 'Nested Array Value',
    'nested_value_explanation' => 'This value is a nested array and cannot be edited directly in this interface. Use the file editor instead.',
    'invalid_value_type' => 'Invalid value type',
    'fallback' => 'Fallback',
    
    // Admin Translation Management
    'translation_management' => 'Translation Management',
    'available_languages' => 'Available Languages',
    'add_language' => 'Add Language',
    'language_code' => 'Language Code',
    'language_name' => 'Language Name',
    'actions' => 'Actions',
    'edit' => 'Edit',
    'delete' => 'Delete',
    'confirm_delete_language' => 'Are you sure you want to delete this language? All translation files will be permanently removed.',
    'cannot_delete_default_language' => 'Cannot delete the default language.',
    'language_created' => 'Language created successfully.',
    'language_deleted' => 'Language deleted successfully.',
    
    'back_to_languages' => 'Back to Languages',
    'files' => 'Files',
    'add_translation_file' => 'Add Translation File',
    'file_name' => 'File Name',
    'confirm_delete_file' => 'Are you sure you want to delete this file?',
    'no_translation_files' => 'No Translation Files',
    'no_translation_files_description' => 'This language does not have any translation files yet. Click the "Add Translation File" button to create one.',
    'translation_file_created' => 'Translation file created successfully.',
    'translation_file_deleted' => 'Translation file deleted successfully.',
    
    'edit_translations' => 'Edit :file Translations for :language',
    'back_to_files' => 'Back to Files',
    'save_translations' => 'Save Translations',
    'translations' => 'Translations',
    'translation_key' => 'Key',
    'english_text' => 'English Text',
    'translation_text' => 'Translation',
    'no_translations_found' => 'No translations found in this file.',
    'translations_updated' => 'Translations updated successfully.',
    'non_string_value' => 'This value is not a string and cannot be edited directly.',
    
    'add_new_language' => 'Add New Language',
    'language_code_help' => 'Two-letter ISO 639-1 language code (e.g., en, fr, es)',
    'language_name_in_native' => 'The name of the language in its native form',
    'create_language' => 'Create Language',
    
    'add_translation_file_for' => 'Add Translation File for :language',
    'file_name_help' => 'The name of the translation file without extension (e.g., common, auth, messages)',
    'create_file' => 'Create File',
    
    'language_translations' => ':language Translations',

    // User management
    'user_created' => 'User created successfully.',
    'user_create_failed' => 'Failed to create user.',
    'user_updated' => 'User updated successfully.',
    'user_update_failed' => 'Failed to update user.',
    'user_deleted' => 'User deleted successfully.',
    'user_delete_failed' => 'Failed to delete user.',
    'cannot_delete_self' => 'You cannot delete your own account.',
    
    // Todo management
    'todo_created' => 'Todo created successfully.',
    'todo_create_failed' => 'Failed to create todo.',
    'todo_updated' => 'Todo updated successfully.',
    'todo_update_failed' => 'Failed to update todo.',
    'todo_deleted' => 'Todo deleted successfully.',
    'todo_delete_failed' => 'Failed to delete todo.',

    // Added translation management keys
    'scan_for_translations' => 'Scan for Translations',
    'translation_guidelines' => 'Translation Guidelines',
    'use_flat_keys' => 'Use flat keys without nesting (file.key, not file.section.key)',
    'use_file_key_format' => 'Format keys as filename.keyname (e.g., common.welcome)',
    'scan_periodically' => 'Periodically scan for new translation keys in your application',
    'import_keys' => 'Import Keys',
    'translations_imported' => 'Translation keys imported successfully.',
    'cannot_import_to_source_language' => 'Cannot import keys to the source language.',
    'translation_keys_scanned' => 'Translation keys scanned and added successfully.',
    'no_new_translation_keys' => 'No new translation keys found.',
]; 