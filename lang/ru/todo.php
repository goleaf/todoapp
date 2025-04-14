<?php

return [
    // Todo model attributes
    'id' => 'ID',
    'title' => 'Заголовок',
    'description' => 'Описание',
    'due_date' => 'Срок',
    'status' => 'Статус',
    'priority' => 'Приоритет',
    'created_at' => 'Создано',
    'updated_at' => 'Обновлено',
    
    // Status options
    'status_pending' => 'Ожидает',
    'status_in_progress' => 'В процессе',
    'status_completed' => 'Завершено',
    
    // Priority options
    'priority_low' => 'Низкий',
    'priority_medium' => 'Средний',
    'priority_high' => 'Высокий',
    
    // API messages
    'created' => 'Задача успешно создана.',
    'updated' => 'Задача успешно обновлена.',
    'deleted' => 'Задача успешно удалена.',
    'not_found' => 'Задача не найдена.',
    'unauthorized' => 'У вас нет доступа к этой задаче.',
    'invalid_parent' => 'Указана неверная родительская задача.',
    'self_parent' => 'Задача не может быть собственным родителем.',
    
    // UI labels
    'todos' => 'Задачи',
    'todo' => 'Задача',
    'create' => 'Создать задачу',
    'edit' => 'Редактировать задачу',
    'delete' => 'Удалить задачу',
    'add_new' => 'Добавить новую задачу',
    'mark_completed' => 'Отметить как завершенную',
    'mark_in_progress' => 'Отметить как в процессе',
    'mark_pending' => 'Отметить как ожидающую',
    'no_todos' => 'Задачи не найдены.',
    'due_today' => 'Срок сегодня',
    'overdue' => 'Просрочено',
    'completed_todos' => 'Завершенные задачи',
    'pending_todos' => 'Ожидающие задачи',
    'in_progress_todos' => 'Задачи в процессе',
    'view_subtasks' => 'Просмотреть подзадачи',
    'add_subtask' => 'Добавить подзадачу',
]; 