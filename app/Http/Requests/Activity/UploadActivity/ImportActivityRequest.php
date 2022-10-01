<?php

declare(strict_types=1);

namespace App\Http\Requests\Activity\UploadActivity;

use App\Http\Requests\Activity\ActivityBaseRequest;
use Illuminate\Support\Facades\Validator;

/**
 * Class ImportActivityRequest.
 */
class ImportActivityRequest extends ActivityBaseRequest
{
    /**
     * Construct.
     */
    public function __construct()
    {
        Validator::extend(
            'activity_file',
            function ($attribute, $value, $parameters, $validator) {
                $mimes = ['application/excel', 'application/vnd.ms-excel', 'application/msexcel', 'text/csv', 'text/xml', 'application/xml'];
                $fileMime = $value->getClientMimeType();

                return in_array($fileMime, $mimes, true);
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
        $rules['activity'] = 'required|activity_file';

        return $rules;
    }

    /**
     * prepare error message.
     *
     * @return array
     */
    public function messages(): array
    {
        $messages['activity.required'] = trans('validation.required', ['attribute' => trans('activity_file')]);
        $messages['activity.activity_file'] = trans('validation.mimes', ['attribute' => trans('global.activity'), 'values' => 'csv']);

        return $messages;
    }
}
