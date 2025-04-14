<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
            'color' => 'nullable|string|max:7', // e.g., #RRGGBB
        ];

        if ($this->isMethod('post')) {
            // Required on creation
            $rules['name'] = [
                'required',
                'string',
                'max:255',
                // Unique category name per user
                Rule::unique('categories')->where(function ($query) use ($userId) {
                    return $query->where('user_id', $userId);
                })
            ];
        } else {
            // Sometimes required on update (allow partial updates)
            $rules['name'] = [
                'sometimes',
                'required',
                'string',
                'max:255',
                // Unique category name per user, ignoring self
                Rule::unique('categories')->where(function ($query) use ($userId) {
                    return $query->where('user_id', $userId);
                })->ignore($this->route('category')?->id)
            ];
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
            'name.required' => __('validation.required', ['attribute' => __('category.name')]),
            'name.string' => __('validation.string', ['attribute' => __('category.name')]),
            'name.max' => __('validation.max_string', ['attribute' => __('category.name'), 'max' => 255]),
            'name.unique' => __('validation.unique', ['attribute' => __('category.name')]),
            'color.string' => __('validation.string', ['attribute' => __('category.color')]),
            'color.max' => __('validation.max_string', ['attribute' => __('category.color'), 'max' => 7]),
        ];
    }
} 