<?php

declare(strict_types=1);

namespace App\Constants;

/**
 * Class Enums.
 */
abstract class Enums
{
    const IATI_ORGANIZATION_STATUS
    = [
        'pending',
        'verified',
    ];

    const ORGANIZATION_STATUS
    = [
        'draft',
        'ready_to_publish',
        'published',
    ];

    const BULK_PUBLISHING_STATUS
    = [
        'created',
        'processing',
        'completed',
        'failed',
    ];

    const STATUS = [
        'active',
        'inactive',
    ];

    const ORGANIZATION_SYSTEM_STATUS = [
        'active',
        'disabled',
    ];

    const REGISTRATION_METHOD = [
        'new_org',
        'existing_org',
        'user_create',
    ];

    const LANGUAGE_PREFERENCE = [
        'en',
        'fr',
        'es',
    ];

    const UPLOAD_TYPE = [
        'manual' => 'manual',
        'csv'    => 'csv',
        'xml'    => 'xml',
    ];

    const API_TYPE = [
        'internal',
        'external',
    ];

    const IMPORT_STATUS = [
        'progress',
        'completed',
    ];

    const IMPORT_TYPE = [
        'xml',
        'csv',
        'xls',
    ];
}
