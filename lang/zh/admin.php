<?php

return [
  'translations' => '翻译',
  'page_title' => '管理翻译',
  'edit_locale_page_title' => '编辑语言区域 :locale | 翻译',
  'editing_locale_heading' => '正在编辑 :locale (:name)',
  'new_locale_placeholder' => '输入语言区域代码（例如：es）',
  'new_locale_title' => '语言区域代码，例如：en, es, fr-CA',
  'add_locale_button' => '添加语言区域',
  'no_locales_title' => '未找到语言',
  'no_locales_desc' => '添加您的第一门语言以开始管理翻译。',
  'locale_code' => '语言区域代码',
  'language_name' => '语言名称',
  'actions' => '操作',
  'edit_button' => '编辑文件',
  'delete_button' => '删除',
  'delete_locale_confirm' => '您确定要删除语言区域 \':locale\' 及其所有文件吗？此操作无法撤销。',
  'back_to_list' => '返回语言区域列表',
  'add_file_button' => '添加文件',
  'new_file_placeholder' => '输入文件名（不含 .php）',
  'new_file_title' => '文件名（例如：validation, messages）',
  'no_files_title' => '未找到翻译文件',
  'no_files_desc' => '为此语言区域添加您的第一个翻译文件。',
  'save_file_button' => '保存文件',
  'delete_file_confirm' => '您确定要删除文件 \':file.php\' 吗？此操作无法撤销。',
  'key' => '键',
  'value' => '值',
  'edit_key' => '编辑',
  'no_translations' => '此文件中未找到翻译。',
  'nested_array' => '嵌套数组',
  'edit_key_title' => '编辑翻译键 - :key | :file',
  'editing_key_heading' => '正在编辑 :file 中的键 ":key"',
  'back_to_translations' => '返回翻译列表',
  'translation_value' => '翻译',
  'save_translations' => '保存翻译',
  'nested_value_warning' => '嵌套数组值',
  'nested_value_explanation' => '此值为嵌套数组，无法在此界面直接编辑。请改用文件编辑器。',
  'invalid_value_type' => '无效的值类型',
  'fallback' => '后备',
  'translation_management' => '翻译管理',
  'available_languages' => '可用语言',
  'add_language' => '添加语言',
  'language_code' => '语言代码',
  'edit' => '编辑',
  'delete' => '删除',
  'confirm_delete_language' => '您确定要删除此语言吗？所有翻译文件将被永久移除。',
  'cannot_delete_default_language' => '无法删除默认语言。',
  'language_created' => '语言创建成功。',
  'language_deleted' => '语言删除成功。',
  'back_to_languages' => '返回语言列表',
  'files' => '文件',
  'add_translation_file' => '添加翻译文件',
  'file_name' => '文件名',
  'confirm_delete_file' => '您确定要删除此文件吗？',
  'no_translation_files' => '无翻译文件',
  'no_translation_files_description' => '该语言尚无任何翻译文件。点击"添加翻译文件"按钮创建一个。',
  'translation_file_created' => '翻译文件创建成功。',
  'translation_file_deleted' => '翻译文件删除成功。',
  'edit_translations' => '编辑 :language 的 :file 翻译',
  'back_to_files' => '返回文件列表',
  'translation_key' => '键',
  'english_text' => '英文文本',
  'translation_text' => '翻译',
  'no_translations_found' => '此文件中未找到翻译。',
  'translations_updated' => '翻译更新成功。',
  'non_string_value' => '此值不是字符串，无法直接编辑。',
  'add_new_language' => '添加新语言',
  'language_code_help' => '两位 ISO 639-1 语言代码（例如：en, fr, es）',
  'language_name_in_native' => '该语言的母语名称',
  'create_language' => '创建语言',
  'add_translation_file_for' => '为 :language 添加翻译文件',
  'file_name_help' => '翻译文件名，不带扩展名（例如：common, auth, messages）',
  'create_file' => '创建文件',
  'language_translations' => ':language 翻译',
  'user_created' => '用户创建成功。',
  'user_create_failed' => '创建用户失败。',
  'user_updated' => '用户更新成功。',
  'user_update_failed' => '更新用户失败。',
  'user_deleted' => '用户删除成功。',
  'user_delete_failed' => '删除用户失败。',
  'cannot_delete_self' => '您不能删除自己的帐户。',
  'todo_created' => '待办事项创建成功。',
  'todo_create_failed' => '创建待办事项失败。',
  'todo_updated' => '待办事项更新成功。',
  'todo_update_failed' => '更新待办事项失败。',
  'todo_deleted' => '待办事项删除成功。',
  'todo_delete_failed' => '删除待办事项失败。',
  'scan_for_translations' => '扫描翻译',
  'translation_guidelines' => '翻译指南',
  'use_flat_keys' => '使用扁平键，不嵌套（file.key，而非 file.section.key）',
  'use_file_key_format' => '将键格式化为 filename.keyname（例如：common.welcome）',
  'scan_periodically' => '定期扫描应用程序中的新翻译键',
  'import_keys' => '导入键',
  'translations_imported' => '翻译键导入成功。',
  'cannot_import_to_source_language' => '无法将键导入源语言。',
  'translation_keys_scanned' => '翻译键扫描并添加成功。',
  'no_new_translation_keys' => '未发现新的翻译键。',
];
