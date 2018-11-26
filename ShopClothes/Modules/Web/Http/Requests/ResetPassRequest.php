<?php

namespace Modules\Web\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPassRequest extends FormRequest
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
            'old_pass'                  => 'required',
            'new_pass'                  => 'required',
            'confirm_new_pass'          => 'required|same:new_pass',
        ];
    }
    
    public function messages()
    {
        return [
            'old_pass.required'                  => 'Bạn vui lòng nhập password hiện tại',
            'new_pass.required'                  => 'Bạn vui lòng nhập password mới',
            'confirm_new_pass.required'          => 'Bạn vui lòng nhập lại password',
            'confirm_new_pass.same'              => 'Mật khẩu xác nhận không trùng khớp với mật khẩu mới đã nhập',
        ];
    }
}
