<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMenuRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            // 'route' => ['required', 'string', 'max:255', 'unique:menus,route'],
            'route' => [
                'required',
                'string',
                'max:255',
                Rule::unique('menus', 'route')
                    ->ignore($this->menu->id),
            ],
            'icon' => ['nullable', 'string'],
            'parent_uuid' => ['nullable', 'exists:menus,uuid'],
            'order' => ['nullable', 'integer'],
            'permission' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ];
    }
}
