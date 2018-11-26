<?php

namespace Modules\Web\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        
        return true;
    }

    /**
    * Get the validation rules that apply to the request.
    *
    * @return array
    */
    public function rules()
    {   
        return [
            'user_fullname'             => 'required',
            'user_password'             => 'required|min:6',
            'user_password_confirm'     => 'required|same:user_password',
            'check_requestment'         => 'required',
            'user_email_phone'          => 'required|unique:tbl_user,user_email|unique:tbl_user,user_mobile_phone'
        ];
    }
    
    public function messages()
    {
        return [
            'user_fullname.required'             =>  'Bạn vui lòng nhập họ tên',
            'user_password.required'             =>  'Bạn vui lòng nhập mật khẩu',
            'user_password.min'                  =>  'Mật khẩu phải ít nhất 6 ký tự',
            'check_requestment.required'         =>  'Bạn chưa đồng ý với điều khoản và chính sách của Sharingeconomy',
            'user_email_phone.required'          =>  'Bạn vui lòng nhập email hoặc số điện thoại di động',
            'user_email_phone.unique'            => 'Email hoặc số điện thoại này đã tồn tại',
            'user_password_confirm.required'     => 'Bạn vui lòng nhập lại mật khẩu',
            'user_password_confirm.same'         => 'Mật khẩu xác nhận không khớp',
        ];
    }
}
