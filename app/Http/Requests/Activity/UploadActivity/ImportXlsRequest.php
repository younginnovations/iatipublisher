<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\UploadActivity;

use App\Http\Requests\Activity\ActivityBaseRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Class ImportXlsRequest.
 */
class ImportXlsRequest extends ActivityBaseRequest
{
    /**
     * Construct.
     */
    public function __construct()
    {
        Validator::extend(
            'activity_file',
            function ($attribute, $value, $parameters, $validator) {
                // $mimes = ['application/excel', 'application/vnd.ms-excel', 'application/msexcel', 'application/xls','application/x-dos_ms_excel', 'application/x-xls', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet (xlsx)'];
                // $fileMime = $value->getClientMimeType();

                // return in_array($fileMime, $mimes, true);
                return true;
            }
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [];
        $rules['activity'] = 'required|activity_file| max:10000';

        return $rules;
    }

    /**
     * prepare error message.
     *
     * @return array
     */
    public function messages(): array
    {
        $messages['activity.required'] = 'The xls file must be uploaded';
        $messages['activity.activity_file'] = 'The file must be of either oof xls format.';
        $messages['activity.max'] = 'The file shouldn\'t be greater than 10MB.';

        return $messages;
    }

    /**
     * Overwritten failedValidation method for JSON response.
     *
     * @param Validator $validator
     *
     * @return ValidationException
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator): ValidationException
    {
        $response = new JsonResponse(['success' => false, 'errors' => $validator->errors()]);

        throw new ValidationException($validator, $response);
    }
}
