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

    'accepted'             => 'fr_ The :attribute must be accepted.',
    'accepted_if'          => 'fr_ The :attribute must be accepted when :other is :value.',
    'active_url'           => 'fr_ The :attribute is not a valid URL.',
    'after'                => 'fr_ The :attribute must be a date after :date.',
    'after_or_equal'       => 'fr_ The :attribute must be a date after or equal to :date.',
    'alpha'                => 'fr_ The :attribute must only contain letters.',
    'alpha_dash'           => 'fr_ The :attribute must only contain letters, numbers, dashes and underscores.',
    'alpha_num'            => 'fr_ The :attribute must only contain letters and numbers.',
    'array'                => 'fr_ The :attribute must be an array.',
    'before'               => 'fr_ The :attribute must be a date before :date.',
    'before_or_equal'      => 'fr_ The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => 'fr_ The :attribute must be between :min and :max.',
        'file'    => 'fr_ The :attribute must be between :min and :max kilobytes.',
        'string'  => 'fr_ The :attribute must be between :min and :max characters.',
        'array'   => 'fr_ The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'fr_ The :attribute field must be true or false.',
    'confirmed'            => 'fr_ The :attribute confirmation does not match.',
    'current_password'     => 'fr_ The password is incorrect.',
    'date'                 => 'fr_ The :attribute is not a valid date.',
    'date_equals'          => 'fr_ The :attribute must be a date equal to :date.',
    'date_format'          => 'fr_ The :attribute does not match the format :format.',
    'declined'             => 'fr_ The :attribute must be declined.',
    'declined_if'          => 'fr_ The :attribute must be declined when :other is :value.',
    'different'            => 'fr_ The :attribute and :other must be different.',
    'digits'               => 'fr_ The :attribute must be :digits digits.',
    'digits_between'       => 'fr_ The :attribute must be between :min and :max digits.',
    'dimensions'           => 'fr_ The :attribute has invalid image dimensions.',
    'distinct'             => 'fr_ The :attribute field has a duplicate value.',
    'email'                => 'fr_ The :attribute must be a valid email address.',
    'ends_with'            => 'fr_ The :attribute must end with one of the following: :values.',
    'enum'                 => 'fr_ The selected :attribute is invalid.',
    'exists'               => 'fr_ The selected :attribute is invalid.',
    'file'                 => 'fr_ The :attribute must be a file.',
    'filled'               => 'fr_ The :attribute field must have a value.',
    'gt'                   => [
        'numeric' => 'fr_ The :attribute must be greater than :value.',
        'file'    => 'fr_ The :attribute must be greater than :value kilobytes.',
        'string'  => 'fr_ The :attribute must be greater than :value characters.',
        'array'   => 'fr_ The :attribute must have more than :value items.',
    ],
    'gte'                  => [
        'numeric' => 'fr_ The :attribute must be greater than or equal to :value.',
        'file'    => 'fr_ The :attribute must be greater than or equal to :value kilobytes.',
        'string'  => 'fr_ The :attribute must be greater than or equal to :value characters.',
        'array'   => 'fr_ The :attribute must have :value items or more.',
    ],
    'image'                => 'fr_ The :attribute must be an image.',
    'in'                   => 'fr_ The selected :attribute is invalid.',
    'in_array'             => 'fr_ The :attribute field does not exist in :other.',
    'integer'              => 'fr_ The :attribute must be an integer.',
    'ip'                   => 'fr_ The :attribute must be a valid IP address.',
    'ipv4'                 => 'fr_ The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'fr_ The :attribute must be a valid IPv6 address.',
    'json'                 => 'fr_ The :attribute must be a valid JSON string.',
    'lt'                   => [
        'numeric' => 'fr_ The :attribute must be less than :value.',
        'file'    => 'fr_ The :attribute must be less than :value kilobytes.',
        'string'  => 'fr_ The :attribute must be less than :value characters.',
        'array'   => 'fr_ The :attribute must have less than :value items.',
    ],
    'lte'                  => [
        'numeric' => 'fr_ The :attribute must be less than or equal to :value.',
        'file'    => 'fr_ The :attribute must be less than or equal to :value kilobytes.',
        'string'  => 'fr_ The :attribute must be less than or equal to :value characters.',
        'array'   => 'fr_ The :attribute must not have more than :value items.',
    ],
    'mac_address'          => 'fr_ The :attribute must be a valid MAC address.',
    'max'                  => [
        'numeric' => 'fr_ The :attribute must not be greater than :max.',
        'file'    => 'fr_ The :attribute must not be greater than :max kilobytes.',
        'string'  => 'fr_ The :attribute must not be greater than :max characters.',
        'array'   => 'fr_ The :attribute must not have more than :max items.',
    ],
    'mimes'                => 'fr_ The :attribute must be a file of type: :values.',
    'mimetypes'            => 'fr_ The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'fr_ The :attribute must be at least :min.',
        'file'    => 'fr_ The :attribute must be at least :min kilobytes.',
        'string'  => 'fr_ The :attribute must be at least :min characters.',
        'array'   => 'fr_ The :attribute must have at least :min items.',
    ],
    'multiple_of'          => 'fr_ The :attribute must be a multiple of :value.',
    'not_in'               => 'fr_ The selected :attribute is invalid.',
    'not_regex'            => 'fr_ The :attribute format is invalid.',
    'numeric'              => 'fr_ The :attribute must be a number.',
    'password'             => 'fr_ The password is incorrect.',
    'present'              => 'fr_ The :attribute field must be present.',
    'prohibited'           => 'fr_ The :attribute field is prohibited.',
    'prohibited_if'        => 'fr_ The :attribute field is prohibited when :other is :value.',
    'prohibited_unless'    => 'fr_ The :attribute field is prohibited unless :other is in :values.',
    'prohibits'            => 'fr_ The :attribute field prohibits :other from being present.',
    'regex'                => 'fr_ The :attribute format is invalid.',
    'required'             => 'fr_ The :attribute field is required.',
    'required_array_keys'  => 'fr_ The :attribute field must contain entries for: :values.',
    'required_if'          => 'fr_ The :attribute field is required when :other is :value.',
    'required_unless'      => 'fr_ The :attribute field is required unless :other is in :values.',
    'required_with'        => 'fr_ The :attribute field is required when :values is present.',
    'required_with_all'    => 'fr_ The :attribute field is required when :values are present.',
    'required_without'     => 'fr_ The :attribute field is required when :values is not present.',
    'required_without_all' => 'fr_ The :attribute field is required when none of :values are present.',
    'same'                 => 'fr_ The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'fr_ The :attribute must be :size.',
        'file'    => 'fr_ The :attribute must be :size kilobytes.',
        'string'  => 'fr_ The :attribute must be :size characters.',
        'array'   => 'fr_ The :attribute must contain :size items.',
    ],
    'starts_with'          => 'fr_ The :attribute must start with one of the following: :values.',
    'string'               => 'fr_ The :attribute must be a string.',
    'timezone'             => 'fr_ The :attribute must be a valid timezone.',
    'unique'               => 'fr_ The :attribute has already been taken.',
    'uploaded'             => 'fr_ The :attribute failed to upload.',
    'url'                  => 'fr_ The :attribute must be a valid URL.',
    'uuid'                 => 'fr_ The :attribute must be a valid UUID.',

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
            'rule-name' => 'fr_ custom-message',
        ],
    ],

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
    'sum'                                              => 'fr_ The sum of percentage within a vocabulary must add up to 100.',
    'overall_sum'                                      => 'fr_ The sum of percentage must not be more than 100.',
    'required_custom'                                  => 'fr_ :attribute is required when there are multiple codes.',
    'total'                                            => 'fr_ :attribute should be 100 when there is only one :values.',
    'csv_required'                                     => 'fr_ At row :number :attribute is required',
    'csv_unique'                                       => 'fr_ At row :number :attribute should be unique',
    'csv_invalid'                                      => 'fr_ At row :number :attribute is invalid',
    'csv_numeric'                                      => 'fr_ At row :number :attribute should be numeric',
    'csv_unique_validation'                            => 'fr_ At row :number :attribute is invalid and must be unique.',
    'csv_among'                                        => 'fr_ At row :number at least one :type among :attribute is required.',
    'csv_only_one'                                     => 'fr_ At row :number only one among :attribute is required.',
    'year_value_narrative_validation'                  => 'fr_ :year and :value is required if :narrative is not empty.',
    'year_narrative_validation'                        => 'fr_ :year is required if :narrative is not empty.',
    'org_required'                                     => 'fr_ At least one organisation name is required',
    'custom_unique'                                    => 'fr_ :attribute has already been taken.',
    'user_identifier_taken'                            => 'fr_ Sorry! this User Identifier is already taken',
    'enter_valid'                                      => 'fr_ Please enter valid :attribute',
    'sector_validation'                                => 'fr_ Sector must be present either at Activity or in all Transactions level.',
    'sector_narrative'                                 => 'fr_ <a href=\'%s\' >Sector Narrative</a> is required when vocabulay is 98 or 99.',
    'transaction_sector_narrative'                     => 'fr_ <a href=\'%s\' >Transaction Sector Narrative</a> is required when vocabulay is 98 or 99.',
    'transaction_sector_validation'                    => 'fr_ All Transactions must contain Sector element.',
    'sector_in_activity_and_transaction_remove'        => 'fr_ You can only mention Sector either at Activity or in Transaction level(should be included in all transactions) but not both. <br/>Please click the link to remove Sector From: <a href=\'%s\' class=\'delete_data\'>Transaction Level</a> OR <a href=\'%s\' class=\'delete_data\'>Activity Level</a>',
    'sector_in_activity_and_transaction'               => 'fr_ You need to mention either Recipient Country or Region either in Activity Level or in Transaction level. You can\'t have Country/Region in both Activity level and Transaction level. Also, they cannot be empty for both activity and transactions',
    'recipient_country_or_region_required'             => 'fr_ Either Recipient Country or Recipient Region is required in Activity Level or Transaction Level.',
    'transaction_recipient_country_or_region_required' => 'fr_ All Transactions must contain Recipient Region or Recipient Country',
    'sum_of_percentage'                                => 'fr_ The sum of percentage in :attribute must be 100.',
    'validation_before_completed'                      => 'fr_ Please make sure you enter the following fields before changing to completed state.',
    'reporting_org_identifier_unique'                  => 'fr_ This reporting organization identifier is being used by :orgName. This identifier has to be unique. Please contact us at support@aidstream.org',
    'code_list'                                        => 'fr_ :attribute is not valid.',
    'string'                                           => 'fr_ :attribute should be string',
    'negative'                                         => 'fr_ :attribute cannot be negative',
    'actual_date'                                      => 'fr_ Actual Start Date And Actual End Date must not exceed present date',
    'multiple_activity_date'                           => 'fr_ Multiple Activity dates are not allowed.',
    'start_end_date'                                   => 'fr_ Actual Start Date or Planned Start Date should be before Actual End Date or Planned End Date.',
    'csv_date'                                         => 'fr_ :attribute must be of format Y-m-d.',
    'multiple_values'                                  => 'fr_ Multiple :attribute are not allowed.',
    'csv_size'                                         => 'fr_ At least one :attribute is required',
    'multiple_narratives'                              => 'fr_ Multiple narratives for :attribute with the same type is not allowed.',
    'required_only_one_among'                          => 'fr_ Either :attribute or :values is required.',
    'recipient_country_region_percentage_sum'          => 'fr_ Sum of percentage of Recipient Country and Recipient Region must be equal to 100.',
    'invalid_in_transaction'                           => 'fr_ Entered :attribute is incorrect in Transaction.',
    'invalid_in_sector'                                => 'fr_ Entered :attribute is incorrect in Sector.',
    'required_if_in_transaction'                       => 'fr_ :attribute is required if :values is not present in Transaction.',
    'sector_vocabulary_required'                       => 'fr_ Sector Vocabulary is required in Transaction if not present in Activity Level.',
    'required_in_transaction'                          => 'fr_ :attribute is required in Transaction.',
    'invalid_language'                                 => 'fr_ Invalid :attribute language',
    'unique_lang'                                      => 'fr_ Repeated :attribute in the same language is not allowed.',
    'indicator_ascending'                              => 'fr_ Indicator Ascending should be true/false, 0/1 or Yes/No.',
    'indicator_size'                                   => 'fr_ Indicator Baseline Year or Value should occur once and no more than once within an Indicator.',
    'narrative_required'                               => 'fr_ :attribute Narrative is required.',
    'no_more_than_once'                                => 'fr_ :attribute should occur once and no more than once within :values.',
    'budget_period_end_date'                           => 'fr_ Budget Period End Date',
    'spaces_not_allowed'                               => 'fr_ You cannot enter spaces in organization name abbreviation.',
    'custom'                                           => [
        'attribute-name' => [
            'rule-name' => 'fr_ custom-message',
        ],
    ],
    'not_in_spam_emails'                               => 'fr_ This email has been flagged as spam and cannot be used.',
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

    'attributes' => [
        'username'              => 'fr_ username',
        'full_name'             => 'fr_ full name',
        'email'                 => 'fr_ email',
        'publisher_id'          => 'fr_ publisher id',
        'publisher_name'        => 'fr_ publisher name',
        'identifier'            => 'fr_ identifier',
        'password'              => 'fr_ password',
        'password_confirmation' => 'fr_ password confirmation',
        'registration_agency'   => 'fr_ registration agency',
        'registration_number'   => 'fr_ registration number',
        'country'               => 'fr_ country',
        'default_language'      => 'fr_ default language',
        'publisher_type'        => 'fr_ publisher type',
        'license_id'            => 'fr_ license id',
        'description'           => 'fr_ description',
        'image_url'             => 'fr_ image url',
        'contact_email'         => 'fr_ contact email',
        'website'               => 'fr_ website',
        'source'                => 'fr_ source',
        'language_preference'   => 'fr_ language preference',
        'current_password'      => 'fr_ current password',
    ],
    'within_a_year'     => 'fr_ The :attribute must be within a year after :date.',
    'required_if_any'   => 'fr_ The :field is required if any of the fields of :element are filled.',
    'amount'            => 'fr_ Please enter amount in the format xx.xx',
    'greater'           => 'fr_ The :attribute must be greater than or equal to :value',
    'date_greater_than' => 'fr_ The date must be greater than :value',
    'logged_in_verify'  => 'fr_ User must be logged in to verify email.',
];
