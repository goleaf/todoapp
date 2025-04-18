<?php

return [
  'translations' => 'Переводы',
  'page_title' => 'Управление переводами',
  'edit_locale_page_title' => 'Редактировать локаль :locale | Переводы',
  'editing_locale_heading' => 'Редактирование :locale (:name)',
  'new_locale_placeholder' => 'Введите код региона (например, es)',
  'new_locale_title' => 'Код локали, например, en, es, fr-CA',
  'add_locale_button' => 'Добавить локализацию',
  'no_locales_title' => 'Языки не найдены',
  'no_locales_desc' => 'Добавьте свой родной язык, чтобы начать управлять переводами.',
  'locale_code' => 'Код местности',
  'language_name' => 'Название языка',
  'actions' => 'Действия',
  'edit_button' => 'Редактировать файлы',
  'delete_button' => 'Удалить',
  'delete_locale_confirm' => 'Вы уверены, что хотите удалить локаль :locale и все ее файлы? Это действие необратимо.',
  'back_to_list' => 'Назад к локалям',
  'add_file_button' => 'Добавить файл',
  'new_file_placeholder' => 'Введите имя файла (без .php)',
  'new_file_title' => 'Имя файла (например, validation, messages)',
  'no_files_title' => 'Файлы переводов не найдены',
  'no_files_desc' => 'Добавьте ваш первый файл перевода для этой локали.',
  'save_file_button' => 'Сохранить файл',
  'delete_file_confirm' => 'Вы уверены, что хотите удалить файл :file.php? Это действие необратимо.',
  'key' => 'Ключ',
  'value' => 'Значение',
  'edit_key' => 'Редактировать',
  'no_translations' => 'Переводы в этом файле не найдены.',
  'nested_array' => 'Вложенный массив',
  'edit_key_title' => 'Редактировать ключ перевода - :key | :file',
  'editing_key_heading' => 'Редактирование ключа ":key" в :file',
  'back_to_translations' => 'Назад к переводам',
  'translation_value' => 'Перевод',
  'save_translations' => 'Сохранить переводы',
  'nested_value_warning' => 'Значение вложенного массива',
  'nested_value_explanation' => 'Это значение является вложенным массивом и не может быть отредактировано непосредственно в этом интерфейсе. Используйте редактор файлов.',
  'invalid_value_type' => 'Недопустимый тип значения',
  'fallback' => 'Резервный',
  'translation_management' => 'Управление переводами',
  'available_languages' => 'Доступные языки',
  'add_language' => 'Добавить язык',
  'language_code' => 'Код языка',
  'edit' => 'Редактировать',
  'delete' => 'Удалить',
  'confirm_delete_language' => 'Вы уверены, что хотите удалить этот язык? Все файлы переводов будут безвозвратно удалены.',
  'cannot_delete_default_language' => 'Невозможно удалить язык по умолчанию.',
  'language_created' => 'Язык успешно создан.',
  'language_deleted' => 'Язык успешно удален.',
  'back_to_languages' => 'Назад к языкам',
  'files' => 'Файлы',
  'add_translation_file' => 'Добавить файл перевода',
  'file_name' => 'Имя файла',
  'confirm_delete_file' => 'Вы уверены, что хотите удалить этот файл?',
  'no_translation_files' => 'Файлы переводов не найдены',
  'no_translation_files_description' => 'У этого языка пока нет файлов перевода. Нажмите кнопку "Добавить файл перевода", чтобы создать его.',
  'translation_file_created' => 'Файл перевода успешно создан.',
  'translation_file_deleted' => 'Файл перевода успешно удален.',
  'edit_translations' => 'Редактировать переводы :file для :language',
  'back_to_files' => 'Назад к файлам',
  'translation_key' => 'Ключ',
  'english_text' => 'Английский текст',
  'translation_text' => 'Перевод',
  'no_translations_found' => 'Переводы в этом файле не найдены.',
  'translations_updated' => 'Переводы успешно обновлены.',
  'non_string_value' => 'Это значение не является строкой и не может быть отредактировано непосредственно.',
  'add_new_language' => 'Добавить новый язык',
  'language_code_help' => 'Двухбуквенный код языка ISO 639-1 (например, en, fr, es)',
  'language_name_in_native' => 'Название языка на его родном языке',
  'create_language' => 'Создать язык',
  'add_translation_file_for' => 'Добавить файл перевода для :language',
  'file_name_help' => 'Название файла перевода без расширения (например, common, auth, messages)',
  'create_file' => 'Создать файл',
  'language_translations' => 'Переводы для :language',
  'user_created' => 'Пользователь успешно создан.',
  'user_create_failed' => 'Не удалось создать пользователя.',
  'user_updated' => 'Пользователь успешно обновлен.',
  'user_update_failed' => 'Не удалось обновить пользователя.',
  'user_deleted' => 'Пользователь успешно удален.',
  'user_delete_failed' => 'Не удалось удалить пользователя.',
  'cannot_delete_self' => 'Вы не можете удалить свою учетную запись.',
  'todo_created' => 'Задача успешно создана.',
  'todo_create_failed' => 'Не удалось создать задачу.',
  'todo_updated' => 'Задача успешно обновлена.',
  'todo_update_failed' => 'Не удалось обновить задачу.',
  'todo_deleted' => 'Задача успешно удалена.',
  'todo_delete_failed' => 'Не удалось удалить задачу.',
  'scan_for_translations' => 'Сканировать переводы',
  'translation_guidelines' => 'Руководство по переводу',
  'use_flat_keys' => 'Используйте плоские ключи без вложенности (file.key, а не file.section.key)',
  'use_file_key_format' => 'Форматируйте ключи как имяфайла.имяключа (например, common.welcome)',
  'scan_periodically' => 'Периодически сканируйте на наличие новых ключей перевода в вашем приложении',
  'import_keys' => 'Импортировать ключи',
  'translations_imported' => 'Ключи перевода успешно импортированы.',
  'cannot_import_to_source_language' => 'Невозможно импортировать ключи в исходный язык.',
  'translation_keys_scanned' => 'Ключи перевода отсканированы и успешно добавлены.',
  'no_new_translation_keys' => 'Новые ключи перевода не найдены.',
];
