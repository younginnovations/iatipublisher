<?php

namespace App\Http\Requests\Activity\UploadActivity;

use App\Http\Requests\Activity\ActivityBaseRequest;
use Illuminate\Support\Facades\Validator;

/**
 * Class ImportActivityRequest.
 */
class ImportActivityRequest extends ActivityBaseRequest
{
    public function __construct()
    {
        Validator::extend(
            'activity_file',
            function ($attribute, $value, $parameters, $validator) {
                $mimes = ['application/excel', 'application/vnd.ms-excel', 'application/msexcel', 'text/csv', 'text/xml', 'application/xml'];
                $fileMime = $value->getClientMimeType();

                return in_array($fileMime, $mimes);
            }
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        $rules['activity'] = 'required|activity_file';

        return $rules;
    }

    /**
     * prepare error message.
     * @return mixed
     */
    public function messages()
    {
        $messages['activity.required'] = trans('validation.required', ['attribute' => trans('elementForm.activity_file')]);
        $messages['activity.activity_file'] = trans('validation.mimes', ['attribute' => trans('global.activity'), 'values' => 'csv']);

        return $messages;
    }
}
