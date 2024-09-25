<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'username' => 'required|max:32|unique:users,username,'.  $this->id,
            'fullname' => 'required|max:70',
            'email' => 'required|email|max:80|unique:users,email,'.  $this->id,
            'password' => [
              'nullable',
              'min:7',
              'max:255',
              'regex:/^(?!.*(\d)\1\1)(?!.*([A-Za-z])\2\2)(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
            ],
            'roles' => 'required',
            'status' => 'required',
            'avatar' => 'nullable|image|max:2048|mimes:jpeg,png,jpg',
        ];
    }

    public function messages(): array
    {
      return [
        'username.required' => 'Trường tài khoản là bắt buộc.',
        'username.max' => 'Tài khoản không được vượt quá :max ký tự.',
        'username.unique' => 'Tài khoản này đã được sử dụng.',
  
        'fullname.required' => 'Trường họ và tên là bắt buộc.',
        'fullname.max' => 'Họ và tên không được vượt quá :max ký tự.',
  
        'email.required' => 'Trường email là bắt buộc.',
        'email.email' => 'Địa chỉ email không hợp lệ.',
        'email.max' => 'Email không được vượt quá :max ký tự.',
        'email.unique' => 'Email này đã được sử dụng.',
  
        'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
        'password.max' => 'Mật khẩu không được vượt quá :max ký tự.',
        'password.regex' => 'Mật khẩu phải có chữ hoa, chữ thường, số, ký tự đặc biệt và không có 3 chữ hoặc số liên tiếp liền nhau.',
  
        'roles.required' => 'Vui lòng chọn vai trò cho người dùng',
  
        'status.required' => 'Trường trạng thái là bắt buộc.',

        'avatar.image' => 'File phải là một hình ảnh.',
        'avatar.max' => 'Kích thước file ảnh không được vượt quá 2MB.',
        'avatar.mimes' => 'Định dạng ảnh phải là jpeg, png hoặc jpg.',
      ];
    }
}
