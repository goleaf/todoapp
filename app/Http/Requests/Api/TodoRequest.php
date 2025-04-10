<?php

namespace App\Http\Requests\Api;

use App\Enums\TodoPriority;
use App\Enums\TodoStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;

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
        $rules = [
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
}
