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
class UserUpdateRequest extends FormRequest
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
        $request = $this->all();
        $id = request()->route('id');
        $role = Auth::user()->role->role;

        $rules = [
            'username'              => ['required', 'max:255', 'string', 'regex:/^[a-z]([0-9a-z-_])*$/', sprintf('unique:users,username,%d', $id)],
            'full_name'             => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'string', 'email', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix', 'max:255', sprintf('unique:users,email,%d', $id)],
        ];

        if (!empty(Arr::get($request, 'password', null))) {
            $rules['password'] = ['required', 'string', 'min:6', 'max:255', 'confirmed'];
            $rules['password_confirmation'] = ['required', 'string', 'min:6', 'max:255'];
        }
        if ($role === 'admin') {
            $rules['role_id'] = 'required';
        }

        return $rules;
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