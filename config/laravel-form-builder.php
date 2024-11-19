<?php

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormHelper;

return [
    'defaults' => [
        // 'wrapper_class'       => 'form-group form-field-group',
        'wrapper_class' => 'subelement rounded-t-sm 13 border-l border-spring-50 pb-11',
        'wrapper_error_class' => 'has_error',
        'label_class' => 'flex control-label py-4 px-6 font-bold text-sm leading-relaxed rounded-t-sm  items-center',
        'field_class' => 'form-control',
        'field_error_class' => '',
        'help_block_class' => 'help-block help-text',
        'error_class' => 'text-danger error py-2',
        'required_class' => 'required',
        'help_block_tag' => 'p',

        // Override a class from a field.
        //'text'                => [
        //    'wrapper_class'   => 'form-field-text',
        //    'label_class'     => 'form-field-text-label',
        //    'field_class'     => 'form-field-text-field',
        //]
        //'radio'               => [
        //    'choice_options'  => [
        //        'wrapper'     => ['class' => 'form-radio'],
        //        'label'       => ['class' => 'form-radio-label'],
        //        'field'       => ['class' => 'form-radio-field'],
        //],
    ],
    // Templates
    'form' => 'laravel-form-builder::form',
    'text' => 'laravel-form-builder::text',
    'textarea' => 'laravel-form-builder::textarea',
    'button' => 'laravel-form-builder::button',
    'buttongroup' => 'laravel-form-builder::buttongroup',
    'radio' => 'laravel-form-builder::radio',
    'checkbox' => 'laravel-form-builder::checkbox',
    'select' => 'laravel-form-builder::select',
    'choice' => 'laravel-form-builder::choice',
    'repeated' => 'laravel-form-builder::repeated',
    'child_form' => 'laravel-form-builder::child_form',
    'collection' => 'laravel-form-builder::collection',
    'static' => 'laravel-form-builder::static',

    // Remove the laravel-form-builder:: prefix above when using template_prefix
    'template_prefix' => '',

    'default_namespace' => '',

    'custom_fields' => [
//        'datetime' => App\Forms\Fields\Datetime::class
    ],

    'plain_form_class' => Form::class,
    'form_builder_class' => FormBuilder::class,
    'form_helper_class' => FormHelper::class,
];
