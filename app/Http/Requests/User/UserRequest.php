<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

/**
 * Class UserRequest.
 */
class UserRequest extends FormRequest
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
        $role = Auth::user()->role->role;

        $rules = [
            'username'              => ['required', 'max:255', 'string', 'unique:users,username'],
            'full_name'             => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'string', 'email', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,}$/ix', 'max:255', 'unique:users,email'],
            'status'                => ['required'],
            'password'              => ['required', 'string', 'min:6', 'max:255', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:6', 'max:255'],
        ];

        if ($role === 'admin') {
            $rules['role_id'] = 'required';
        }

        return $rules;
    }

    /**
     * Prepares data before validation.
     *
     * @return void
     * @throws \JsonException
     */
    public function prepareForValidation(): void
    {
        $this->decryptPassword();
    }

    /**
     * Decrypt and update password and password field of form request.
     *
     * @return void
     * @throws \JsonException
     */
    public function decryptPassword(): void
    {
        $request = $this->all();
        $password = Arr::get($request, 'password', null);
        $password_confirmation = Arr::get($request, 'password_confirmation', null);

        $this->merge([
            'password' => $password ? decryptString($password, env('MIX_ENCRYPTION_KEY')) : '',
            'password_confirmation' => $password_confirmation ? decryptString($password_confirmation, env('MIX_ENCRYPTION_KEY')) : '',
        ]);
    }

    /**
     * Get validation messages.
     *
     * @return array
     */
    public function messages(): array
    {
        $messages['username.regex'] = 'The username is invalid. Username must be purely lowercase alphabets followed by alphanumeric(ascii) characters and these symbols:-_';

        return $messages;
    }

    /**
     * Overwritten failedValidation method for JSON response.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     *
     * @return ValidationException
     * @throws ValidationException
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator): ValidationException
    {
        $response = new JsonResponse(['success' => false, 'errors' => $validator->errors()]);

        throw new ValidationException($validator, $response);
    }
}
