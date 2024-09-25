<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required|email|max:80',
            'password' => [
              'required',
              'min:7',
              'max:255',
            ],
          ];
    }

    public function messages(): array
    {
      return [
        'email.required' => 'Trường email là bắt buộc.',
        'email.email' => 'Địa chỉ email không hợp lệ.',
        'email.max' => 'Email không được vượt quá :max ký tự.',
  
        'password.required' => 'Trường mật khẩu là bắt buộc.',
        'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
        'password.max' => 'Mật khẩu không được vượt quá :max ký tự.',
      ];
    }
}
