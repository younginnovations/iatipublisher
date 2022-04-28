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
}
