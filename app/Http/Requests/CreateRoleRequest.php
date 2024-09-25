<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRoleRequest extends FormRequest
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
            'name' => ['required', 'max:50', 'unique:roles,name', 'regex:/^\S*$/'], 
            'description' => 'required|max:150',
            'permissions' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập vai trò.',
            'name.regex' => 'Vai trò không được chứa khoảng trắng.',
            'name.max' => 'Vai trò không được vượt quá :max ký tự.',
            'name.unique' => 'Vai trò đã tồn tại.',
        
            'description.required' => 'Vui lòng nhập mô tả.',
            'description.max' => 'Mô tả không được vượt quá :max ký tự.',

            'permissions.required' => 'Vui lòng chọn quyền cho vai trò',
        ];
    }
}
