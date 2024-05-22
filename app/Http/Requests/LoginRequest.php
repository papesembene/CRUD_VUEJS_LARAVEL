<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
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
            'email'=>'required|email|exists:users,email',
            'password'=>'required',
        ];
    }
    public function messages()
    {
        return [
            'email.required'=>'une adresse email doit etre fourni',
            'email.unique'=>'l\'adresse email fourni  existe deja ',
            'email.email'=>'l\'adresse email fourni  non valide ',
            'email.exists'=>'l\'adresse email fourni  n\'existe pas ',
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
