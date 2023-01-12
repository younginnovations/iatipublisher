<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

/**
 * Class UserProfileRequest.
 */
class UserProfileRequest extends FormRequest
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
        $form_type = $this->get('form_type');

        if ($form_type === 'password') {
            $rules = [
                'current_password'      => ['required', 'string', 'min:6', 'max:255'],
                'password'              => ['required', 'string', 'min:6', 'max:255', 'confirmed'],
                'password_confirmation' => ['required', 'string', 'min:6', 'max:255'],
            ];
        } else {
            $id = Auth::user()->id;

            $rules = [
                'username'              => ['required', 'max:255', sprintf('unique:users,username,%d', $id)],
                'full_name'             => ['required', 'string', 'max:255'],
                'email'                 => ['required', 'string', 'email', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix', 'max:255', sprintf('unique:users,email,%d', $id)],
                'language_preference'   => 'required',
            ];
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
        $messages = [];
        $form_type = $this->get('form_type');

        if ($form_type === 'password') {
            $messages['publisher_id.regex'] = 'The publisher id is invalid. The publisher id must be at least two characters long and lower case. It can include letters, numbers and also - (dash) and _ (underscore).';
        } else {
            $messages['username.regex'] = 'The username is invalid. Username must be purely lowercase alphabets followed by alphanumeric(ascii) characters and these symbols:-_';
        }

        return $messages;
    }

    /**
     * Prepares data before validation.
     *
     * @return void
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
        $current_password = Arr::get($request, 'current_password', null);
        $password = Arr::get($request, 'password', null);
        $password_confirmation = Arr::get($request, 'password_confirmation', null);

        $this->merge([
            'current_password' => $current_password ? decryptString($current_password, env('MIX_ENCRYPTION_KEY')) : '',
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
