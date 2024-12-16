<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

/**
 * Helper class to manage import-related caching logic.
 *
 * @class  ImportCacheHelper
 */
class ImportCacheHelper
{
    private const STEP = 'step';

    private const IMPORTING_COMPLETE = 'importing_complete';

    private const VALIDATING_COMPLETE = 'validating_complete';

    private const HAS_ONGOING_IMPORT = 'has_ongoing_import';

    private const SESSION_IMPORT_FILETYPE = 'import_filetype';

    private const ACTIVITY_IDENTIFIERS = 'activity_identifiers';

    private const CACHE_KEY_PATTERN = 'ongoing_import_%s';

    /**
     * Cache Schema.
     */
    private const DEFAULT_CACHE_VALUE = [
        self::HAS_ONGOING_IMPORT   => true,
        self::STEP                 => self::VALIDATING_COMPLETE,
        self::ACTIVITY_IDENTIFIERS => [],
    ];

    /**
     * Checks if a specific activity identifier is already being imported.
     *
     * @param int    $orgId
     * @param string $activityIdentifier
     *
     * @return bool
     */
    public static function activityAlreadyBeingImported(int $orgId, string $activityIdentifier): bool
    {
        return in_array($activityIdentifier, self::getActivityIdentifiersFromCache($orgId), true);
    }

    /**
     * Retrieves activity identifiers from the cache for the given organisation.
     *
     * @param int $orgId
     *
     * @return array
     */
    public static function getActivityIdentifiersFromCache(int $orgId): array
    {
        return Arr::get(self::getCacheValueForOrganisation($orgId), self::ACTIVITY_IDENTIFIERS, []);
    }

    /**
     * Gets the cached value for the given organisation ID.
     *
     * @param int $orgId
     *
     * @return array
     */
    public static function getCacheValueForOrganisation(int $orgId): array
    {
        return Cache::get(self::getCacheKey($orgId), []);
    }

    /**
     * Constructs the cache key for the given organisation ID.
     *
     * @param int $orgId
     *
     * @return string
     */
    public static function getCacheKey(int $orgId): string
    {
        return sprintf(self::CACHE_KEY_PATTERN, $orgId);
    }

    /**
     * Appends an activity identifier to the cache for the given organisation.
     *
     * @param int    $orgId
     * @param string $activityIdentifier
     *
     * @return void
     */
    public static function appendActivityIdentifiersToCache(int $orgId, string $activityIdentifier): void
    {
        $cacheValue = self::getCacheValueForOrganisation($orgId);
        $activityIdentifiers = Arr::get($cacheValue, self::ACTIVITY_IDENTIFIERS, []);

        if (!in_array($activityIdentifier, $activityIdentifiers)) {
            $activityIdentifiers[] = $activityIdentifier;
        }

        $cacheValue[self::ACTIVITY_IDENTIFIERS] = $activityIdentifiers;
        Cache::put(self::getCacheKey($orgId), $cacheValue);
    }

    /**
     * Sets the import step to 'validating_complete' for the given organisation.
     *
     * @param int $orgId
     *
     * @return void
     */
    public static function setImportStepToValidating(int $orgId): void
    {
        $cacheValue = self::getCacheValueForOrganisation($orgId);
        $cacheValue[self::STEP] = self::VALIDATING_COMPLETE;

        Cache::put(self::getCacheKey($orgId), $cacheValue);
    }

    /**
     * Sets the import step to 'importing_complete' for the given organisation.
     *
     * @param int $orgId
     *
     * @return void
     */
    public static function setImportStepToImported(int $orgId): void
    {
        $cacheValue = self::getCacheValueForOrganisation($orgId);
        $cacheValue[self::STEP] = self::IMPORTING_COMPLETE;

        Cache::put(self::getCacheKey($orgId), $cacheValue);
    }

    /**
     * Marks the import as ongoing for the given organisation.
     *
     * @param int $orgId
     *
     * @return void
     */
    public static function beginOngoingImport(int $orgId): void
    {
        $cacheValue = self::getCacheValueForOrganisation($orgId);
        $cacheValue[self::HAS_ONGOING_IMPORT] = true;

        Cache::put(self::getCacheKey($orgId), $cacheValue);
    }

    /**
     * Clears the import cache for the given organisation.
     *
     * @param int $orgId
     *
     * @return void
     */
    public static function clearImportCache(int $orgId): void
    {
        self::organisationHasCompletedImportingData($orgId);
        Cache::forget(self::getCacheKey($orgId));
    }

    /**
     * Checks if the organisation has completed importing data.
     *
     * @param int $orgId
     *
     * @return bool
     */
    public static function organisationHasCompletedImportingData(int $orgId): bool
    {
        return self::getImportStep($orgId) === self::VALIDATING_COMPLETE;
    }

    /**
     * Gets the current import step for the given organisation.
     *
     * @param int $orgId
     *
     * @return string
     */
    public static function getImportStep(int $orgId): string
    {
        return Arr::get(self::getCacheValueForOrganisation($orgId), self::STEP, '');
    }

    /**
     * Checks if the organisation has completed validating data.
     *
     * @param int $orgId
     *
     * @return bool
     */
    public static function organisationHasCompletedValidatingData(int $orgId): bool
    {
        return self::getImportStep($orgId) === self::VALIDATING_COMPLETE;
    }

    /**
     * Checks if there is an ongoing import for the given organisation.
     *
     * @param int $orgId
     *
     * @return bool
     */
    public static function hasOngoingImport(int $orgId): bool
    {
        return Arr::get(self::getCacheValueForOrganisation($orgId), self::HAS_ONGOING_IMPORT, false);
    }

    /**
     * Get import_filetype from cache if not inaccessible from session for some reason.
     *
     * @param int $orgId
     *
     * @return string|null
     */
    public static function getSessionConsistentFiletype(int $orgId): ?string
    {
        return Arr::get(self::getCacheValueForOrganisation($orgId), self::SESSION_IMPORT_FILETYPE, null);
    }

    /**
     * Set import_filetype in cache. Only call when setting in session.
     *
     * @param int    $orgId
     * @param string $filetype
     *
     * @return void
     */
    public static function setSessionConsistentFiletype(int $orgId, string $filetype): void
    {
        $cacheValue = self::getCacheValueForOrganisation($orgId);
        $cacheValue[self::SESSION_IMPORT_FILETYPE] = $filetype;

        Cache::put(self::getCacheKey($orgId), $cacheValue);
    }
}
