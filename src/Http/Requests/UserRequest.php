<?php

/**
 * UserRequest
 *
 * @package App\Http\Requests
 *
 * @class UserRequest
 * 
 * @copyright 2019 SurmountSoft Pvt. Ltd. All rights reserved.
 */

namespace CSoftech\Customer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the product is authorized to make this request.
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
        $userId = isset($this->user) ? $this->user : null;
        
        return [
            'first_name'  => 'required|max:100',
            'last_name'  => 'required|max:100',
            'email' => 'required|max:50|regex:/^([a-z0-9+_\.-]+)@([\da-z+\.-]+)\.([a-z+\.]{2,6})$/|unique:users,email,'.$userId,
            'mobile_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'user_role' => 'required',
        ];
    }
    /**
     * Custom messages
     *
     * @return array
     */
    public function messages()
    {
        return [
           
            'mobile_number.regex' => 'Field must be a number',
            
           
        ];
    }

    
}
