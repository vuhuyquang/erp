<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'fullname' => 'required|max:70',
            'email' => 'required|max:70',
        ];
    }

    public function messages(): array
    {
      return [
        'fullname.required' => 'Trường họ và tên là bắt buộc.',
        'fullname.max' => 'Họ và tên không được vượt quá :max ký tự.',
  
        'email.required' => 'Trường email là bắt buộc.',
        'email.email' => 'Địa chỉ email không hợp lệ.',
        'email.max' => 'Email không được vượt quá :max ký tự.',
      ];
    }
}
