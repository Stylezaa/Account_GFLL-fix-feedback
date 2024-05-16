<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DonorRequest extends FormRequest
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
            "donor_id" => "required|min:1|max:10|unique:KSDonors",
            "donor_sym" =>"required|unique:KSDonors|max:10|min:1",
            "currency" => "required",
            "donor_name_la" => "required|min:1|max:80",
            "donor_name_en" => "required|min:1|max:80",
        ];
    }
}
