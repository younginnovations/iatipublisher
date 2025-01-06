<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'es_ The :attribute must be accepted.',
    'accepted_if'          => 'es_ The :attribute must be accepted when :other is :value.',
    'active_url'           => 'es_ The :attribute is not a valid URL.',
    'after'                => 'es_ The :attribute must be a date after :date.',
    'after_or_equal'       => 'es_ The :attribute must be a date after or equal to :date.',
    'alpha'                => 'es_ The :attribute must only contain letters.',
    'alpha_dash'           => 'es_ The :attribute must only contain letters, numbers, dashes and underscores.',
    'alpha_num'            => 'es_ The :attribute must only contain letters and numbers.',
    'array'                => 'es_ The :attribute must be an array.',
    'before'               => 'es_ The :attribute must be a date before :date.',
    'before_or_equal'      => 'es_ The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => 'es_ The :attribute must be between :min and :max.',
        'file'    => 'es_ The :attribute must be between :min and :max kilobytes.',
        'string'  => 'es_ The :attribute must be between :min and :max characters.',
        'array'   => 'es_ The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'es_ The :attribute field must be true or false.',
    'confirmed'            => 'es_ The :attribute confirmation does not match.',
    'current_password'     => 'es_ The password is incorrect.',
    'date'                 => 'es_ The :attribute is not a valid date.',
    'date_equals'          => 'es_ The :attribute must be a date equal to :date.',
    'date_format'          => 'es_ The :attribute does not match the format :format.',
    'declined'             => 'es_ The :attribute must be declined.',
    'declined_if'          => 'es_ The :attribute must be declined when :other is :value.',
    'different'            => 'es_ The :attribute and :other must be different.',
    'digits'               => 'es_ The :attribute must be :digits digits.',
    'digits_between'       => 'es_ The :attribute must be between :min and :max digits.',
    'dimensions'           => 'es_ The :attribute has invalid image dimensions.',
    'distinct'             => 'es_ The :attribute field has a duplicate value.',
    'email'                => 'es_ The :attribute must be a valid email address.',
    'ends_with'            => 'es_ The :attribute must end with one of the following: :values.',
    'enum'                 => 'es_ The selected :attribute is invalid.',
    'exists'               => 'es_ The selected :attribute is invalid.',
    'file'                 => 'es_ The :attribute must be a file.',
    'filled'               => 'es_ The :attribute field must have a value.',
    'gt'                   => [
        'numeric' => 'es_ The :attribute must be greater than :value.',
        'file'    => 'es_ The :attribute must be greater than :value kilobytes.',
        'string'  => 'es_ The :attribute must be greater than :value characters.',
        'array'   => 'es_ The :attribute must have more than :value items.',
    ],
    'gte'                  => [
        'numeric' => 'es_ The :attribute must be greater than or equal to :value.',
        'file'    => 'es_ The :attribute must be greater than or equal to :value kilobytes.',
        'string'  => 'es_ The :attribute must be greater than or equal to :value characters.',
        'array'   => 'es_ The :attribute must have :value items or more.',
    ],
    'image'                => 'es_ The :attribute must be an image.',
    'in'                   => 'es_ The selected :attribute is invalid.',
    'in_array'             => 'es_ The :attribute field does not exist in :other.',
    'integer'              => 'es_ The :attribute must be an integer.',
    'ip'                   => 'es_ The :attribute must be a valid IP address.',
    'ipv4'                 => 'es_ The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'es_ The :attribute must be a valid IPv6 address.',
    'json'                 => 'es_ The :attribute must be a valid JSON string.',
    'lt'                   => [
        'numeric' => 'es_ The :attribute must be less than :value.',
        'file'    => 'es_ The :attribute must be less than :value kilobytes.',
        'string'  => 'es_ The :attribute must be less than :value characters.',
        'array'   => 'es_ The :attribute must have less than :value items.',
    ],
    'lte'                  => [
        'numeric' => 'es_ The :attribute must be less than or equal to :value.',
        'file'    => 'es_ The :attribute must be less than or equal to :value kilobytes.',
        'string'  => 'es_ The :attribute must be less than or equal to :value characters.',
        'array'   => 'es_ The :attribute must not have more than :value items.',
    ],
    'mac_address'          => 'es_ The :attribute must be a valid MAC address.',
    'max'                  => [
        'numeric' => 'es_ The :attribute must not be greater than :max.',
        'file'    => 'es_ The :attribute must not be greater than :max kilobytes.',
        'string'  => 'es_ The :attribute must not be greater than :max characters.',
        'array'   => 'es_ The :attribute must not have more than :max items.',
    ],
    'mimes'                => 'es_ The :attribute must be a file of type: :values.',
    'mimetypes'            => 'es_ The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'es_ The :attribute must be at least :min.',
        'file'    => 'es_ The :attribute must be at least :min kilobytes.',
        'string'  => 'es_ The :attribute must be at least :min characters.',
        'array'   => 'es_ The :attribute must have at least :min items.',
    ],
    'multiple_of'          => 'es_ The :attribute must be a multiple of :value.',
    'not_in'               => 'es_ The selected :attribute is invalid.',
    'not_regex'            => 'es_ The :attribute format is invalid.',
    'numeric'              => 'es_ The :attribute must be a number.',
    'password'             => 'es_ The password is incorrect.',
    'present'              => 'es_ The :attribute field must be present.',
    'prohibited'           => 'es_ The :attribute field is prohibited.',
    'prohibited_if'        => 'es_ The :attribute field is prohibited when :other is :value.',
    'prohibited_unless'    => 'es_ The :attribute field is prohibited unless :other is in :values.',
    'prohibits'            => 'es_ The :attribute field prohibits :other from being present.',
    'regex'                => 'es_ The :attribute format is invalid.',
    'required'             => 'es_ The :attribute field is required.',
    'required_array_keys'  => 'es_ The :attribute field must contain entries for: :values.',
    'required_if'          => 'es_ The :attribute field is required when :other is :value.',
    'required_unless'      => 'es_ The :attribute field is required unless :other is in :values.',
    'required_with'        => 'es_ The :attribute field is required when :values is present.',
    'required_with_all'    => 'es_ The :attribute field is required when :values are present.',
    'required_without'     => 'es_ The :attribute field is required when :values is not present.',
    'required_without_all' => 'es_ The :attribute field is required when none of :values are present.',
    'same'                 => 'es_ The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'es_ The :attribute must be :size.',
        'file'    => 'es_ The :attribute must be :size kilobytes.',
        'string'  => 'es_ The :attribute must be :size characters.',
        'array'   => 'es_ The :attribute must contain :size items.',
    ],
    'starts_with'          => 'es_ The :attribute must start with one of the following: :values.',
    'string'               => 'es_ The :attribute must be a string.',
    'timezone'             => 'es_ The :attribute must be a valid timezone.',
    'unique'               => 'es_ The :attribute has already been taken.',
    'uploaded'             => 'es_ The :attribute failed to upload.',
    'url'                  => 'es_ The :attribute must be a valid URL.',
    'uuid'                 => 'es_ The :attribute must be a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'es_ custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes'                                       => [],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */
    'sum'                                              => 'es_ The sum of percentage within a vocabulary must add up to 100.',
    'overall_sum'                                      => 'es_ The sum of percentage must not be more than 100.',
    'required_custom'                                  => 'es_ :attribute is required when there are multiple codes.',
    'total'                                            => 'es_ :attribute should be 100 when there is only one :values.',
    'csv_required'                                     => 'es_ At row :number :attribute is required',
    'csv_unique'                                       => 'es_ At row :number :attribute should be unique',
    'csv_invalid'                                      => 'es_ At row :number :attribute is invalid',
    'csv_numeric'                                      => 'es_ At row :number :attribute should be numeric',
    'csv_unique_validation'                            => 'es_ At row :number :attribute is invalid and must be unique.',
    'csv_among'                                        => 'es_ At row :number at least one :type among :attribute is required.',
    'csv_only_one'                                     => 'es_ At row :number only one among :attribute is required.',
    'year_value_narrative_validation'                  => 'es_ :year and :value is required if :narrative is not empty.',
    'year_narrative_validation'                        => 'es_ :year is required if :narrative is not empty.',
    'org_required'                                     => 'es_ At least one organisation name is required',
    'custom_unique'                                    => 'es_ :attribute has already been taken.',
    'user_identifier_taken'                            => 'es_ Sorry! this User Identifier is already taken',
    'enter_valid'                                      => 'es_ Please enter valid :attribute',
    'sector_validation'                                => 'es_ Sector must be present either at Activity or in all Transactions level.',
    'sector_narrative'                                 => 'es_ <a href=\'%s\' >Sector Narrative</a> is required when vocabulay is 98 or 99.',
    'transaction_sector_narrative'                     => 'es_ <a href=\'%s\' >Transaction Sector Narrative</a> is required when vocabulay is 98 or 99.',
    'transaction_sector_validation'                    => 'es_ All Transactions must contain Sector element.',
    'sector_in_activity_and_transaction_remove'        => 'es_ You can only mention Sector either at Activity or in Transaction level(should be included in all transactions) but not both. <br/>Please click the link to remove Sector From: <a href=\'%s\' class=\'delete_data\'>Transaction Level</a> OR <a href=\'%s\' class=\'delete_data\'>Activity Level</a>',
    'sector_in_activity_and_transaction'               => 'es_ You need to mention either Recipient Country or Region either in Activity Level or in Transaction level. You can\'t have Country/Region in both Activity level and Transaction level. Also, they cannot be empty for both activity and transactions',
    'recipient_country_or_region_required'             => 'es_ Either Recipient Country or Recipient Region is required in Activity Level or Transaction Level.',
    'transaction_recipient_country_or_region_required' => 'es_ All Transactions must contain Recipient Region or Recipient Country',
    'sum_of_percentage'                                => 'es_ The sum of percentage in :attribute must be 100.',
    'validation_before_completed'                      => 'es_ Please make sure you enter the following fields before changing to completed state.',
    'reporting_org_identifier_unique'                  => 'es_ This reporting organization identifier is being used by :orgName. This identifier has to be unique. Please contact us at support@aidstream.org',
    'code_list'                                        => 'es_ :attribute is not valid.',
    'string'                                           => 'es_ :attribute should be string',
    'negative'                                         => 'es_ :attribute cannot be negative',
    'actual_date'                                      => 'es_ Actual Start Date And Actual End Date must not exceed present date',
    'multiple_activity_date'                           => 'es_ Multiple Activity dates are not allowed.',
    'start_end_date'                                   => 'es_ Actual Start Date or Planned Start Date should be before Actual End Date or Planned End Date.',
    'csv_date'                                         => 'es_ :attribute must be of format Y-m-d.',
    'multiple_values'                                  => 'es_ Multiple :attribute are not allowed.',
    'csv_size'                                         => 'es_ At least one :attribute is required',
    'multiple_narratives'                              => 'es_ Multiple narratives for :attribute with the same type is not allowed.',
    'required_only_one_among'                          => 'es_ Either :attribute or :values is required.',
    'recipient_country_region_percentage_sum'          => 'es_ Sum of percentage of Recipient Country and Recipient Region must be equal to 100.',
    'invalid_in_transaction'                           => 'es_ Entered :attribute is incorrect in Transaction.',
    'invalid_in_sector'                                => 'es_ Entered :attribute is incorrect in Sector.',
    'required_if_in_transaction'                       => 'es_ :attribute is required if :values is not present in Transaction.',
    'sector_vocabulary_required'                       => 'es_ Sector Vocabulary is required in Transaction if not present in Activity Level.',
    'required_in_transaction'                          => 'es_ :attribute is required in Transaction.',
    'invalid_language'                                 => 'es_ Invalid :attribute language',
    'unique_lang'                                      => 'es_ Repeated :attribute in the same language is not allowed.',
    'indicator_ascending'                              => 'es_ Indicator Ascending should be true/false, 0/1 or Yes/No.',
    'indicator_size'                                   => 'es_ Indicator Baseline Year or Value should occur once and no more than once within an Indicator.',
    'narrative_required'                               => 'es_ :attribute Narrative is required.',
    'no_more_than_once'                                => 'es_ :attribute should occur once and no more than once within :values.',
    'budget_period_end_date'                           => 'es_ Budget Period End Date',
    'spaces_not_allowed'                               => 'es_ You cannot enter spaces in organization name abbreviation.',
    'custom'                                           => [
        'attribute-name' => [
            'rule-name' => 'es_ custom-message',
        ],
    ],
    'not_in_spam_emails'                               => 'es_ This email has been flagged as spam and cannot be used.',
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes'        => [],
    'within_a_year'     => 'es_ The :attribute must be within a year after :date.',
    'required_if_any'   => 'es_ The :field is required if any of the fields of :element are filled.',
    'amount'            => 'es_ Please enter amount in the format xx.xx',
    'greater'           => 'es_ The :attribute must be greater than or equal to :value',
    'date_greater_than' => 'es_ The date must be greater than :value',
    'logged_in_verify'  => 'es_ User must be logged in to verify email.',
];
