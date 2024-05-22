<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;


class RegisterRequest extends FormRequest
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
            'name'=>'required|string',
            'email'=>'required|unique:users,email',
            'password'=>'required|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'le nom doit etre fourni',
            'email.required'=>'une adresse email doit etre fourni',
            'email.unique'=>'l\'adresse email fourni  existe deja ',
            'password.required'=>'un mot de passe est requis',
        ];
    }

    public function failedValidation (Validator $validator)
    {
       throw new HttpResponseException(response()->json([
           'success'=>false,
           'status_code'=>422,
           'error'=>true,
           'message'=>'Erreur de validation',
           'errorsList'=>$validator->errors()
       ]));
    }
}
