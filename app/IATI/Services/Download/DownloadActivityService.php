<?php

declare(strict_types=1);

namespace App\IATI\Services\Download;

use App\CsvImporter\Traits\ChecksCsvHeaders;
use App\IATI\Elements\Xml\XmlGenerator;
use App\IATI\Repositories\Activity\ActivityRepository;

/**
 * Class DownloadActivityService.
 */
class DownloadActivityService
{
    use ChecksCsvHeaders;

    /**
     * @var ActivityRepository
     */
    protected ActivityRepository $activityRepository;

    /**
     * @var XmlGenerator
     */
    protected XmlGenerator $xmlGenerator;

    /**
     * DownloadActivityService Constructor.
     *
     * @param ActivityRepository $activityRepository
     * @param XmlGenerator $xmlGenerator
     */
    public function __construct(
        ActivityRepository $activityRepository,
        XmlGenerator $xmlGenerator
    ) {
        $this->activityRepository = $activityRepository;
        $this->xmlGenerator = $xmlGenerator;
    }

    /**
     * Returns activities having given ids for downloading.
     *
     * @param $activityIds
     *
     * @return object
     */
    public function getActivitiesToDownload($activityIds): object
    {
        return $this->activityRepository->getActivitiesToDownload($activityIds);
    }

    /**
     * Returns formatted csv data for downloading.
     *
     * @param $activities
     *
     * @return array
     */
    public function getCsvData($activities): array
    {
        $data = [];

        //This needs to be modified to get actual data of activities.
        foreach ($this->getCsvHeaderArray('Activity', 'other_fields_transaction') as $csvHeader) {
            $data[0][$csvHeader] = 'Test text';
        }

        return $data;
    }

    /**
     * Returns combined xml for download.
     *
     * @param $activities
     *
     * @return string
     */
    public function getCombinedXmlFile($activities): string
    {
        return $this->xmlGenerator->getCombinedXmlFile($activities);
    }
}
