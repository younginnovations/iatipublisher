<?php

declare(strict_types=1);

namespace App\Constants;

/**
 * Class Enums.
 */
abstract class Enums
{
    /**
     * Enum for iati organization status.
     *
     * @var array
     */
    public const IATI_ORGANIZATION_STATUS
        = [
            'pending',
            'verified',
        ];

    /**
     * Enum for organization status.
     *
     * @var array
     */
    public const ORGANIZATION_STATUS
        = [
            'draft',
            'ready_to_publish',
            'published',
        ];

    /**
     * Enum for bulk publishing status.
     *
     * @var array
     */
    public const BULK_PUBLISHING_STATUS
        = [
            'created',
            'processing',
            'completed',
            'failed',
        ];

    /**
     * Enum for status for activeness of user.
     *
     * @var array
     */
    public const STATUS = [
        'active',
        'inactive',
    ];

    /**
     * Enum for organization status for activeness or organization.
     *
     * @var array
     */
    public const ORGANIZATION_SYSTEM_STATUS = [
        'active',
        'disabled',
    ];

    /**
     * Enum for registration method of user.
     *
     * @var array
     */
    public const REGISTRATION_METHOD = [
        'new_org',
        'existing_org',
        'user_create',
    ];

    /**
     * Enum for Organization registration method.
     *
     * @var array
     */
    const ORGANIZATION_REGISTRATION_METHOD = [
        'new_org',
        'existing_org',
    ];

    /**
     * Enum for language preference of user.
     *
     * @var array
     */
    const LANGUAGE_PREFERENCE = [
        'en',
        'fr',
        'es',
    ];

    /**
     * Enum for upload type of activity.
     *
     * @var array
     */
    public const UPLOAD_TYPE = [
        'manual' => 'manual',
        'csv' => 'csv',
        'xml' => 'xml',
        'xls' => 'xls',
    ];

    /**
     * Enum for api type.
     *
     * @var array
     */
    public const API_TYPE = [
        'internal',
        'external',
    ];

    /**
     * Enum for status of importing activity.
     *
     * @var array
     */
    public const IMPORT_STATUS = [
        'processing',
        'completed',
        'failed',
    ];

    /**
     * Enum for type of import.
     *
     * @var array
     */
    public const IMPORT_TYPE = [
        'xml',
        'csv',
        'xls',
    ];

    /**
     * Enum for template of xls import.
     *
     * @var array
     */
    public const IMPORT_TEMPLATE_TYPE = [
        'activity',
        'result',
        'indicator',
        'period',
    ];
}
