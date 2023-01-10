<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

/**
 * Class RegisterRequest
 *
 * @package App\Http\Requests
 */
class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:60',
            'phone' => 'required|string|regex:/(\+380)[0-9]{9}/',
            'email' => 'required|email:rfc,dns',
            'position_id' => 'required|exists:positions,id',
            'photo' => 'required|image|mimes:jpg,jpeg|dimensions:width=70,height=70|max:5000',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'fails' => $validator->errors(),
        ], 422));
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'photo.max' => "The photo may not be greater than 5 Mbytes.",
        ];
    }
}
