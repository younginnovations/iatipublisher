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

    'accepted'             => 'FR__ The :attribute must be accepted.',
    'accepted_if'          => 'FR__ The :attribute must be accepted when :other is :value.',
    'active_url'           => 'FR__ The :attribute is not a valid URL.',
    'after'                => 'FR__ The :attribute must be a date after :date.',
    'after_or_equal'       => 'FR__ The :attribute must be a date after or equal to :date.',
    'alpha'                => 'FR__ The :attribute must only contain letters.',
    'alpha_dash'           => 'FR__ The :attribute must only contain letters, numbers, dashes and underscores.',
    'alpha_num'            => 'FR__ The :attribute must only contain letters and numbers.',
    'array'                => 'FR__ The :attribute must be an array.',
    'before'               => 'FR__ The :attribute must be a date before :date.',
    'before_or_equal'      => 'FR__ The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => 'FR__ The :attribute must be between :min and :max.',
        'file'    => 'FR__ The :attribute must be between :min and :max kilobytes.',
        'string'  => 'FR__ The :attribute must be between :min and :max characters.',
        'array'   => 'FR__ The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'FR__ The :attribute field must be true or false.',
    'confirmed'            => 'FR__ The :attribute confirmation does not match.',
    'current_password'     => 'FR__ The password is incorrect.',
    'date'                 => 'FR__ The :attribute is not a valid date.',
    'date_equals'          => 'FR__ The :attribute must be a date equal to :date.',
    'date_format'          => 'FR__ The :attribute does not match the format :format.',
    'declined'             => 'FR__ The :attribute must be declined.',
    'declined_if'          => 'FR__ The :attribute must be declined when :other is :value.',
    'different'            => 'FR__ The :attribute and :other must be different.',
    'digits'               => 'FR__ The :attribute must be :digits digits.',
    'digits_between'       => 'FR__ The :attribute must be between :min and :max digits.',
    'dimensions'           => 'FR__ The :attribute has invalid image dimensions.',
    'distinct'             => 'FR__ The :attribute field has a duplicate value.',
    'email'                => 'FR__ The :attribute must be a valid email address.',
    'ends_with'            => 'FR__ The :attribute must end with one of the following: :values.',
    'enum'                 => 'FR__ The selected :attribute is invalid.',
    'exists'               => 'FR__ The selected :attribute is invalid.',
    'file'                 => 'FR__ The :attribute must be a file.',
    'filled'               => 'FR__ The :attribute field must have a value.',
    'gt'                   => [
        'numeric' => 'FR__ The :attribute must be greater than :value.',
        'file'    => 'FR__ The :attribute must be greater than :value kilobytes.',
        'string'  => 'FR__ The :attribute must be greater than :value characters.',
        'array'   => 'FR__ The :attribute must have more than :value items.',
    ],
    'gte'                  => [
        'numeric' => 'FR__ The :attribute must be greater than or equal to :value.',
        'file'    => 'FR__ The :attribute must be greater than or equal to :value kilobytes.',
        'string'  => 'FR__ The :attribute must be greater than or equal to :value characters.',
        'array'   => 'FR__ The :attribute must have :value items or more.',
    ],
    'image'                => 'FR__ The :attribute must be an image.',
    'in'                   => 'FR__ The selected :attribute is invalid.',
    'in_array'             => 'FR__ The :attribute field does not exist in :other.',
    'integer'              => 'FR__ The :attribute must be an integer.',
    'ip'                   => 'FR__ The :attribute must be a valid IP address.',
    'ipv4'                 => 'FR__ The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'FR__ The :attribute must be a valid IPv6 address.',
    'json'                 => 'FR__ The :attribute must be a valid JSON string.',
    'lt'                   => [
        'numeric' => 'FR__ The :attribute must be less than :value.',
        'file'    => 'FR__ The :attribute must be less than :value kilobytes.',
        'string'  => 'FR__ The :attribute must be less than :value characters.',
        'array'   => 'FR__ The :attribute must have less than :value items.',
    ],
    'lte'                  => [
        'numeric' => 'FR__ The :attribute must be less than or equal to :value.',
        'file'    => 'FR__ The :attribute must be less than or equal to :value kilobytes.',
        'string'  => 'FR__ The :attribute must be less than or equal to :value characters.',
        'array'   => 'FR__ The :attribute must not have more than :value items.',
    ],
    'mac_address'          => 'FR__ The :attribute must be a valid MAC address.',
    'max'                  => [
        'numeric' => 'FR__ The :attribute must not be greater than :max.',
        'file'    => 'FR__ The :attribute must not be greater than :max kilobytes.',
        'string'  => 'FR__ The :attribute must not be greater than :max characters.',
        'array'   => 'FR__ The :attribute must not have more than :max items.',
    ],
    'mimes'                => 'FR__ The :attribute must be a file of type: :values.',
    'mimetypes'            => 'FR__ The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'FR__ The :attribute must be at least :min.',
        'file'    => 'FR__ The :attribute must be at least :min kilobytes.',
        'string'  => 'FR__ The :attribute must be at least :min characters.',
        'array'   => 'FR__ The :attribute must have at least :min items.',
    ],
    'multiple_of'          => 'FR__ The :attribute must be a multiple of :value.',
    'not_in'               => 'FR__ The selected :attribute is invalid.',
    'not_regex'            => 'FR__ The :attribute format is invalid.',
    'numeric'              => 'FR__ The :attribute must be a number.',
    'password'             => 'FR__ The password is incorrect.',
    'present'              => 'FR__ The :attribute field must be present.',
    'prohibited'           => 'FR__ The :attribute field is prohibited.',
    'prohibited_if'        => 'FR__ The :attribute field is prohibited when :other is :value.',
    'prohibited_unless'    => 'FR__ The :attribute field is prohibited unless :other is in :values.',
    'prohibits'            => 'FR__ The :attribute field prohibits :other from being present.',
    'regex'                => 'FR__ The :attribute format is invalid.',
    'required'             => 'FR__ The :attribute field is required.',
    'required_array_keys'  => 'FR__ The :attribute field must contain entries for: :values.',
    'required_if'          => 'FR__ The :attribute field is required when :other is :value.',
    'required_unless'      => 'FR__ The :attribute field is required unless :other is in :values.',
    'required_with'        => 'FR__ The :attribute field is required when :values is present.',
    'required_with_all'    => 'FR__ The :attribute field is required when :values are present.',
    'required_without'     => 'FR__ The :attribute field is required when :values is not present.',
    'required_without_all' => 'FR__ The :attribute field is required when none of :values are present.',
    'same'                 => 'FR__ The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'FR__ The :attribute must be :size.',
        'file'    => 'FR__ The :attribute must be :size kilobytes.',
        'string'  => 'FR__ The :attribute must be :size characters.',
        'array'   => 'FR__ The :attribute must contain :size items.',
    ],
    'starts_with'          => 'FR__ The :attribute must start with one of the following: :values.',
    'string'               => 'FR__ The :attribute must be a string.',
    'timezone'             => 'FR__ The :attribute must be a valid timezone.',
    'unique'               => 'FR__ The :attribute has already been taken.',
    'uploaded'             => 'FR__ The :attribute failed to upload.',
    'url'                  => 'FR__ The :attribute must be a valid URL.',
    'uuid'                 => 'FR__ The :attribute must be a valid UUID.',

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
            'rule-name' => 'FR__ custom-message',
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
    'sum'                                              => 'FR__ The sum of percentage within a vocabulary must add up to 100.',
    'overall_sum'                                      => 'FR__ The sum of percentage must not be more than 100.',
    'required_custom'                                  => 'FR__ :attribute is required when there are multiple codes.',
    'total'                                            => 'FR__ :attribute should be 100 when there is only one :values.',
    'csv_required'                                     => 'FR__ At row :number :attribute is required',
    'csv_unique'                                       => 'FR__ At row :number :attribute should be unique',
    'csv_invalid'                                      => 'FR__ At row :number :attribute is invalid',
    'csv_numeric'                                      => 'FR__ At row :number :attribute should be numeric',
    'csv_unique_validation'                            => 'FR__ At row :number :attribute is invalid and must be unique.',
    'csv_among'                                        => 'FR__ At row :number at least one :type among :attribute is required.',
    'csv_only_one'                                     => 'FR__ At row :number only one among :attribute is required.',
    'year_value_narrative_validation'                  => 'FR__ :year and :value is required if :narrative is not empty.',
    'year_narrative_validation'                        => 'FR__ :year is required if :narrative is not empty.',
    'org_required'                                     => 'FR__ At least one organisation name is required',
    'custom_unique'                                    => 'FR__ :attribute has already been taken.',
    'user_identifier_taken'                            => 'FR__ Sorry! this User Identifier is already taken',
    'enter_valid'                                      => 'FR__ Please enter valid :attribute',
    'sector_validation'                                => 'FR__ Sector must be present either at Activity or in all Transactions level.',
    'sector_narrative'                                 => 'FR__ <a href=\'%s\' >Sector Narrative</a> is required when vocabulay is 98 or 99.',
    'transaction_sector_narrative'                     => 'FR__ <a href=\'%s\' >Transaction Sector Narrative</a> is required when vocabulay is 98 or 99.',
    'transaction_sector_validation'                    => 'FR__ All Transactions must contain Sector element.',
    'sector_in_activity_and_transaction_remove'        => 'FR__ You can only mention Sector either at Activity or in Transaction level(should be included in all transactions) but not both. <br/>Please click the link to remove Sector From: <a href=\'%s\' class=\'delete_data\'>Transaction Level</a> OR <a href=\'%s\' class=\'delete_data\'>Activity Level</a>',
    'sector_in_activity_and_transaction'               => 'FR__ You need to mention either Recipient Country or Region either in Activity Level or in Transaction level. You can\'t have Country/Region in both Activity level and Transaction level. Also, they cannot be empty for both activity and transactions',
    'recipient_country_or_region_required'             => 'FR__ Either Recipient Country or Recipient Region is required in Activity Level or Transaction Level.',
    'transaction_recipient_country_or_region_required' => 'FR__ All Transactions must contain Recipient Region or Recipient Country',
    'sum_of_percentage'                                => 'FR__ The sum of percentage in :attribute must be 100.',
    'validation_before_completed'                      => 'FR__ Please make sure you enter the following fields before changing to completed state.',
    'reporting_org_identifier_unique'                  => 'FR__ This reporting organization identifier is being used by :orgName. This identifier has to be unique. Please contact us at support@aidstream.org',
    'code_list'                                        => 'FR__ :attribute is not valid.',
    'string'                                           => 'FR__ :attribute should be string',
    'negative'                                         => 'FR__ :attribute cannot be negative',
    'actual_date'                                      => 'FR__ Actual Start Date And Actual End Date must not exceed present date',
    'multiple_activity_date'                           => 'FR__ Multiple Activity dates are not allowed.',
    'start_end_date'                                   => 'FR__ Actual Start Date or Planned Start Date should be before Actual End Date or Planned End Date.',
    'csv_date'                                         => 'FR__ :attribute must be of format Y-m-d.',
    'multiple_values'                                  => 'FR__ Multiple :attribute are not allowed.',
    'csv_size'                                         => 'FR__ At least one :attribute is required',
    'multiple_narratives'                              => 'FR__ Multiple narratives for :attribute with the same type is not allowed.',
    'required_only_one_among'                          => 'FR__ Either :attribute or :values is required.',
    'recipient_country_region_percentage_sum'          => 'FR__ Sum of percentage of Recipient Country and Recipient Region must be equal to 100.',
    'invalid_in_transaction'                           => 'FR__ Entered :attribute is incorrect in Transaction.',
    'invalid_in_sector'                                => 'FR__ Entered :attribute is incorrect in Sector.',
    'required_if_in_transaction'                       => 'FR__ :attribute is required if :values is not present in Transaction.',
    'sector_vocabulary_required'                       => 'FR__ Sector Vocabulary is required in Transaction if not present in Activity Level.',
    'required_in_transaction'                          => 'FR__ :attribute is required in Transaction.',
    'invalid_language'                                 => 'FR__ Invalid :attribute language',
    'unique_lang'                                      => 'FR__ Repeated :attribute in the same language is not allowed.',
    'indicator_ascending'                              => 'FR__ Indicator Ascending should be true/false, 0/1 or Yes/No.',
    'indicator_size'                                   => 'FR__ Indicator Baseline Year or Value should occur once and no more than once within an Indicator.',
    'narrative_required'                               => 'FR__ :attribute Narrative is required.',
    'no_more_than_once'                                => 'FR__ :attribute should occur once and no more than once within :values.',
    'budget_period_end_date'                           => 'FR__ Budget Period End Date',
    'spaces_not_allowed'                               => 'FR__ You cannot enter spaces in organization name abbreviation.',
    'custom'                                           => [
        'attribute-name' => [
            'rule-name' => 'FR__ custom-message',
        ],
    ],
    'not_in_spam_emails'                               => 'FR__ This email has been flagged as spam and cannot be used.',
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
    'within_a_year'     => "The :attribute must be within a year after :date.",
    'required_if_any'   => "The :field is required if any of the fields of :element are filled.",
    'amount'            => 'FR__ Please enter amount in the format xx.xx',
    'greater'           => 'FR__ The :attribute must be greater than or equal to :value',
    'date_greater_than' => 'FR__ The date must be greater than :value',
    'logged_in_verify'  => 'FR__ User must be logged in to verify email.',
];
