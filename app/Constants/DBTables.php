<?php

declare(strict_types=1);

namespace App\Constants;

/**
 * Class DBTables.
 */
abstract class DBTables
{
    const ORGANIZATIONS = 'organizations';
    const ORGANIZATION_PUBLISH = 'organization_published';
    const USERS = 'users';
    const SETTINGS = 'settings';
    const DOCUMENTS = 'documents';
    const ACTIVITY = 'activities';

    const RESULT = 'activity_results';
    const INDICATOR = 'activity_result_indicators';
    const PERIOD = 'result_indicator_periods';

    const IMPORT_STATUS = 'import_status';
}
