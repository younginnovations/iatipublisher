<?php

declare(strict_types=1);

namespace App\IATI\Services\Publisher;

use App\IATI\Services\Workflow\RegistryApiHandler;
use App\IATI\Traits\RegistryApiInvoker;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

/**
 * Class PublisherService.
 */
class PublisherService extends RegistryApiHandler
{
    use RegistryApiInvoker;

    /**
     * @var Model|null
     */
    protected $activityPublished = null;

    /**
     * Publishes the activity xml file to the IATI registry.
     *
     * @param $registryInfo
     * @param $activityPublished
     * @param $organization
     */
    public function publishFile($registryInfo, $activityPublished, $organization)
    {
        $this->setFile($activityPublished);
        $this->init(env('REGISTRY_URL'), Arr::get($registryInfo, 'api_token', ''))
             ->setPublisher(Arr::get($registryInfo, 'publisher_id', ''));
//        $this->searchForPublisher($this->publisherId);
        $this->publishToRegistry($organization, $activityPublished->filename);
    }

    /**
     * Set the file attribute.
     * @param $activityPublished
     */
    protected function setFile($activityPublished)
    {
        $this->activityPublished = $activityPublished;
    }

    /**
     * Publish File to the IATI Registry.
     *
     * @param $organization
     * @param $filename
     */
    protected function publishToRegistry($organization, $filename)
    {
        $data = $this->generatePayload($organization, $filename);

        $packageId = $this->extractPackage($filename);

        if ($this->isPackageAvailable($packageId, $this->apiKey)) {
            $this->client->package_update($data);
        } else {
            $this->client->package_create($data);
        }

        $this->updateStatus();
    }

    /**
     * Returns the request header payload while publishing any files to the IATI Registry.
     *
     * @param      $organization
     * @param      $filename
     * @param      $publishingType
     * @param null $publishedFile
     *
     * @return array
     */
    protected function generatePayload($organization, $filename)
    {
        $code = $this->getCode($filename);
        $key = $this->getKey($code);
        $fileType = $this->getFileType($code);
        $title = $this->extractTitle($organization, $fileType);

        dd('WIP');

        return $this->formatHeaders($this->extractPackage($filename), $organization, $this->activityPublished, $key, $fileType, $title);
    }

    /**
     * Get the data type or country code/region code from the filename.
     *
     * @param $filename
     *
     * @return string
     */
    protected function getCode($filename): string
    {
        $filename = str_replace('.xml', '', $filename);

        return substr($filename, strlen($this->publisherId) + 1);
    }

    /**
     * Get the required key for the code provided.
     *
     * @param $code
     *
     * @return string
     */
    protected function getKey($code): string
    {
        if ($code == '998') {
            return 'Others';
        } elseif (is_numeric($code)) {
            return 'region';
        }

        return 'country';
    }

    /**
     * @param $code
     *
     * @return mixed|string
     */
    protected function getFileType($code): mixed
    {
        if ($code === 'org' || $code === 'organisation') {
            return 'organisation';
        }

        return $code;
    }

    /**
     * Extract title for the file being published.
     *
     * @param $organization
     * @param $fileType
     *
     * @return string
     */
    protected function extractTitle($organization, $fileType): string
    {
        if ($fileType == 'organisation') {
            return $organization->name . ' Organisation File';
        }

        return $organization->name . ' Activity File';
    }

    /**
     * Extract the package name from the published filename.
     *
     * @param $filename
     *
     * @return string
     */
    protected function extractPackage($filename): string
    {
        $array = explode('.', $filename);

        return Arr::get($array, 0, '');
    }

    /**
     * Format headers required to publish into the IATI Registry.
     *
     * @param $filename
     * @param $organization
     * @param $publishedFile
     * @param $key
     * @param $code
     * @param $title
     *
     * @return string
     */
    protected function formatHeaders($filename, $organization, $publishedFile, $key, $code, $title)
    {
//        $data = [
//            'title'        => $title,
//            'name'         => $filename,
//            'author_email' => $organization->getAdminUser()->email,
//            'owner_org'    => $this->publisherId,
//            'license_id'   => 'other-open',
//            'resources'    => [
//                [
//                    'format'   => config('xmlFiles.format'),
//                    'mimetype' => config('xmlFiles.mimeType'),
//                    'url'      => Storage::disk('s3')->getDriver()->getAdapter()->getClient()->getObjectUrl(config('filesystems.disks.s3.bucket'), sprintf("%s%s.xml", config('filesystems.s3xml'), $filename))
//                ]
//            ],
//            "filetype"     => ($code != 'organisation') ? 'activity' : $code,
//            $key           => ($code == 'activities' || $code == 'organisation') ? '' : $code,
//            "data_updated" => $publishedFile->updated_at->toDateTimeString(),
//            "language"     => config('app.locale'),
//            "verified"     => "no",
//            "state"        => "active"
//        ];
//
//        if ($code != 'organisation') {
//            $data['activity_count'] = count($publishedFile->published_activities);
//        }
//
//        return json_encode($data);
    }
}
