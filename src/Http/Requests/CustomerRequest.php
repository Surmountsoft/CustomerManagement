<?php
/**
 * @package App\Http\Requests
 *
 * @class CustomerRequest
 *
 * @author Rahul Sharma <rahul.sharma@surmountsoft.in>
 *
 * @copyright 2021 SurmountSoft Pvt. Ltd. All rights reserved.
 */
namespace CSoftech\Customer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
        $customerId = isset($this->customer) ? $this->customer : null;
        return [
            'company_name' => 'required|max:100',
            'first_name'  => 'required|regex:/^[a-zA-Z_~\-!@#\$%\^&\*\(\)\.\- ]+$/u|max:100',
            'last_name'  => 'required|regex:/^[a-zA-Z_~\-!@#\$%\^&\*\(\)\.\- ]+$/u|max:100',
            'email' => 'required|max:50|regex:/^([a-z0-9+_\.-]+)@([\da-z+\.-]+)\.([a-z+\.]{2,6})$/|unique:customers,email,'.$customerId,
            'phone_number' => 'nullable|regex:/^[0-9][0-9]*$/|digits_between:10,15',
            'address_line_1' => 'nullable|required_with:address_line_2|max:100',
            'address_line_2' => 'nullable|max:100',
            'country_id' => 'nullable|required_with:address_line_1',
            'state_id' => 'nullable|required_with:address_line_1',
            'city_id' => 'nullable|required_with:address_line_1',
            'pincode' => 'nullable|required_with:address_line_1|numeric|digits_between:6,10',
        ];
    }

    public function messages()
    {
        return [
            'country_id.required_with' => 'The country field is required when address line one is present',
            'state_id.required_with' => 'The state field is required when address line one is present',
            'city_id.required_with' => 'The city field is required when address line one is present',
        ];
    }
}
