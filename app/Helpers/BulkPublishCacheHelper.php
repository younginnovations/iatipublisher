<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class BulkPublishCacheHelper
{
    /**
     * Default cache structure when there is no cache found for the organization.
     *
     * @var array
     */
    private const EMPTY_CACHE = [
        'status' => false,
        'activity_ids' => [],
    ];

    /**
     * The cache key format used to store bulk publish data for an organization.
     *
     * @var string
     */
    private const CACHE_KEY = 'ongoing_bulk_publish_%s';

    /**
     * Get the cache key for the organization.
     *
     * @param int $orgId
     * @return string
     */
    private static function getCacheKey(int $orgId): string
    {
        return sprintf(self::CACHE_KEY, (string) $orgId);
    }

    /**
     * Retrieve the bulk publish cache for the given organization.
     *
     * @param int $orgId
     * @return array The bulk publish cache or empty cache if none found
     */
    public static function getOrganisationBulkPublishCache(int $orgId): array
    {
        return Cache::get(self::getCacheKey($orgId), self::EMPTY_CACHE);
    }

    /**
     * Check if there is an ongoing bulk publish for a given organization.
     *
     * @param int $orgId
     * @return bool True if there is an ongoing bulk publish, false otherwise
     */
    public static function hasOngoingBulkPublish(int $orgId): bool
    {
        return Arr::get(self::getOrganisationBulkPublishCache($orgId), 'status', false);
    }

    public static function getActivityIdsInCache(int $orgId): array
    {
        return Arr::get(self::getOrganisationBulkPublishCache($orgId), 'activity_ids', []);
    }

    public static function activitiesHaveChanged(int $orgId): bool
    {
        return count(self::getActivityIdsInCache($orgId)) > 0;
    }

    /**
     * Set the initial bulk publish cache for a given organization.
     *
     * @param int $orgId
     * @return void
     */
    public static function setInitialBulkPublishCache(int $orgId): void
    {
        if (!self::hasOngoingBulkPublish($orgId)) {
            $cacheValue = self::EMPTY_CACHE;
            $cacheValue['status'] = true;

            self::updateCache($orgId, $cacheValue);
        }
    }

    /**
     * Append an activity ID in the bulk publish cache for a given organization.
     *
     * @param int $orgId
     * @param int $activityId
     * @return void
     */
    public static function appendActivityIdInBulkPublishCache(int $orgId, int $activityId): void
    {
        $cacheValue = self::getOrganisationBulkPublishCache($orgId);

        if (!in_array($activityId, $cacheValue['activity_ids'], true)) {
            $cacheValue['activity_ids'][] = $activityId;

            self::updateCache($orgId, $cacheValue);
        }
    }

    /**
     * Clear the cache for a given organization.
     * This removes the bulk publish data from the cache.
     *
     * @param int $orgId
     * @return void
     */
    public static function clearBulkPublishCache(int $orgId): void
    {
        Cache::forget(self::getCacheKey($orgId));
    }

    /**
     * Helper method to update the cache for the given organization.
     *
     * @param int $orgId
     * @param array $cacheValue
     * @return void
     */
    private static function updateCache(int $orgId, array $cacheValue): void
    {
        Cache::put(self::getCacheKey($orgId), $cacheValue);
    }
}
