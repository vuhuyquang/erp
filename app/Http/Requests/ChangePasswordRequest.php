<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'oldPassword' => 'required|min:7|max:32',
            'password' => [
                'required',
                'min:7',
                'max:32',
                'different:oldPassword',
                'regex:/^(?!.*(\d)\1\1)(?!.*([A-Za-z])\2\2)(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
            ],
            'reNewPassword' => [
                'required',
                'min:7',
                'max:32',
                'same:password',
                'regex:/^(?!.*(\d)\1\1)(?!.*([A-Za-z])\2\2)(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
            ],
        ];
    }

    public function messages()
    {
        return [
            'oldPassword.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'reNewPassword.required' => 'Vui lòng nhập lại mật khẩu.',

            'oldPassword.min' => 'Trường dữ liệu phải có tối thiểu 7 ký tự.',
            'password.min' => 'Trường dữ liệu phải có tối thiểu 7 ký tự.',
            'reNewPassword.min' => 'Trường dữ liệu phải có tối thiểu 7 ký tự.',

            'oldPassword.max' => 'Trường dữ liệu phải có tối đa 32 ký tự.',
            'password.max' => 'Trường dữ liệu phải có tối đa 32 ký tự.',
            'reNewPassword.max' => 'Trường dữ liệu phải có tối đa 32 ký tự.',

            'password.different' => 'Mật khẩu mới phải khác mật khẩu hiện tại',
            'reNewPassword.same' => 'Mật khẩu khẩu không trùng khớp',
            'password.regex' => 'Mật khẩu phải có chữ hoa, chữ thường, số, ký tự đặc biệt và không có 3 chữ hoặc số liên tiếp liền nhau.',
            'reNewPassword.regex' => 'Mật khẩu phải có chữ hoa, chữ thường, số, ký tự đặc biệt và không có 3 chữ hoặc số liên tiếp liền nhau.',
        ];
    }
}
