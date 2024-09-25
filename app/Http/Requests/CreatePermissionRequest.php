<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePermissionRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'scope' => 'required|max:50|unique:permissions,scope',
            'description' => 'required|max:150',
        ];
    }

    public function messages(): array
    {
        return [
            'scope.required' => 'Vui lòng nhập quyền.',
            'scope.max' => 'Quyền không được vượt quá :max ký tự.',
            'scope.unique' => 'Quyền đã tồn tại.',
        
            'description.required' => 'Vui lòng nhập mô tả.',
            'description.max' => 'Mô tả không được vượt quá :max ký tự.',
        ];
    }
}
