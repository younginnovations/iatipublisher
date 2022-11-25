<?php

declare(strict_types=1);

namespace App\Http\Requests\Web\IatiRegister;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Class IatiRegisterFormRequest.
 */
class IatiRegisterFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get all of the input and files for the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [];
        $step = $this->get('step');
        // dd($step);
        // $request['password'] = isset($request['password']) && $request['password'] ? decryptString($request['password'], env('MIX_ENCRYPTION_KEY')) : '';
        // $request['password_confirmation'] = isset($request['password_confirmation']) && $request['password_confirmation'] ? decryptString($request['password_confirmation'], env('MIX_ENCRYPTION_KEY')) : '';

        switch ($step) {
            case '1':
                $rules = [
                    'publisher_id'        => ['required', 'string', 'max:255', 'unique:organizations,publisher_id'],
                    'publisher_name'      => ['required', 'string', 'max:255', 'unique:organizations,publisher_name'],
                    'identifier'          => ['required', 'string', 'max:255', 'unique:organizations,identifier'],
                    'registration_agency' => ['required'],
                    'registration_number' => ['required'],
                    'publisher_type'      => ['required'],
                    'license_id'          => ['required'],
                    'description'         => ['sometimes'],
                    'image_url'             => ['nullable', 'url'],
                ];
                break;
            case '2':
                $rules = [
                    'contact_email' => ['required', 'string', 'email', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix', 'max:255'],
                    'website' => ['nullable', 'url'],
                ];
                break;
            case '3':
                $rules = [
                    'source' => 'required',
                ];
                break;
            case '4':
                $rules = [
                    'username'              => ['required', 'max:255', 'string', 'regex:/^[A-Za-z]([0-9A-Za-z _])*$/', 'unique:users,username'],
                    'full_name'             => ['required', 'string', 'max:255'],
                    'email'                 => ['required', 'string', 'email', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix', 'max:255', 'unique:users,email'],
                    'password'              => ['required', 'string', 'min:6', 'max:255', 'confirmed'],
                    'password_confirmation' => ['required', 'string', 'min:6', 'max:255'],
                ];
                break;
        }

        return $rules;
    }

    // public function getPasswordValidation(){

    // }

    /**
     * Overwritten failedValidation method for JSON response.
     *
     * @param Validator $validator
     *
     * @return ValidationException
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = new JsonResponse(['success' => false, 'errors' => $validator->errors()]);

        throw new ValidationException($validator, $response);
    }
}
