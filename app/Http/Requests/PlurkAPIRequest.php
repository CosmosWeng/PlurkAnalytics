<?php

namespace App\Http\Requests;

use InfyOm\Generator\Request\APIRequest;

class PlurkAPIRequest extends APIRequest
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
            'oauth_token'        => 'required',
            'oauth_token_secret' => 'required'
        ];
    }
}