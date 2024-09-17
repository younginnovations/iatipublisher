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
    public const ORGANIZATION_REGISTRATION_METHOD = [
        'new_org' => 'New org',
        'existing_org' => 'Existing org',
    ];

    /**
     * Enum for language preference of user.
     *
     * @var array
     */
    public const LANGUAGE_PREFERENCE = [
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
        'max_merge_size_exception',
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

    /*
     * Enums for organisation-registration-agency that are not country dependent
     */
    public const UNCATEGORIZED_ORGANISATION_AGENCY_PREFIX = [
        'XM',
        'XI',
        'XR',
    ];

    public const IATI_XML_VERSION = '2.03';

    public const ACTIVITY_XML_BASE_PATH = 'xml/activityXmlFiles';

    public const MERGED_XML_BASE_PATH = 'xml/mergedActivityXml';

    public const ORG_XML_BASE_PATH = 'organizationXmlFiles';

    public const TOKEN_PENDING = 'Pending';

    public const TOKEN_CORRECT = 'Correct';

    public const TOKEN_INCORRECT = 'Incorrect';

    public const EXISTING_ORG = 'existing_org';

    public const MAX_MERGE_SIZE = '20';

    public const MAX_BATCH_SIZE = '4';
}
