<?php

namespace App\Http\Requests\Api;

use App\Enums\TodoPriority;
use App\Enums\TodoStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rule;

class TodoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $userId = $this->user()->id;

        $rules = [
            'category_id' => [
                'nullable',
                'integer',
                Rule::exists('categories', 'id')->where(function ($query) use ($userId) {
                    return $query->where('user_id', $userId);
                }),
            ],
            'parent_id' => [
                'nullable',
                'integer',
                Rule::exists('todos', 'id')->where(function ($query) use ($userId) {
                    return $query->where('user_id', $userId);
                }),
                Rule::when($this->isMethod('put') || $this->isMethod('patch'), [
                    Rule::notIn([$this->route('todo')?->id]),
                ]),
            ],
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'status' => ['sometimes', new Enum(TodoStatus::class)],
        ];

        if ($this->isMethod('post')) {
            // Required on creation
            $rules['title'] = 'required|string|max:255';
            $rules['priority'] = ['required', new Enum(TodoPriority::class)];
        } else {
            // Sometimes required on update (allow partial updates)
            $rules['title'] = 'sometimes|required|string|max:255';
            $rules['priority'] = ['sometimes', 'required', new Enum(TodoPriority::class)];
        }

        return $rules;
    }
    
    /**
     * Get custom messages for validator errors.
     * 
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => __('validation.required', ['attribute' => __('todo.title')]),
            'title.string' => __('validation.string', ['attribute' => __('todo.title')]),
            'title.max' => __('validation.max.string', ['attribute' => __('todo.title'), 'max' => 255]),
            'description.string' => __('validation.string', ['attribute' => __('todo.description')]),
            'due_date.date' => __('validation.date', ['attribute' => __('todo.due_date')]),
            'priority.required' => __('validation.required', ['attribute' => __('todo.priority')]),
            'category_id.integer' => __('validation.integer', ['attribute' => __('category.category')]),
            'category_id.exists' => __('validation.exists', ['attribute' => __('category.category')]),
            'parent_id.integer' => __('validation.integer', ['attribute' => __('todo.parent')]),
            'parent_id.exists' => __('validation.exists', ['attribute' => __('todo.parent')]),
            'parent_id.not_in' => __('todo.self_parent'),
        ];
    }
}
