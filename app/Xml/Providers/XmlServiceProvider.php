<?php

namespace App\Xml\Providers;

/**
 * Class XmlServiceProvider.
 */
class XmlServiceProvider
{
    /**
     * @var
     */
    protected $validator;
    /**
     * @var
     */
    protected $generator;

    /**
     * Initialize an Xml Generator instance.
     * @param $version
     * @return $this
     */
    public function initializeGenerator($version)
    {
        $this->generator = 'App\IATI\Elements\Xml\XmlGenerator';

        return $this;
    }

    /**
     * Initialize an Xml Validator instance.
     * @param $version
     * @return $this
     */
    public function initializeValidator($version)
    {
        $this->validator = 'App\IATI\Services\ImportActivity\XmlService';

        return $this;
    }

    /**
     * Generate Xml Files.
     * @param $includedActivities
     * @param $filename
     * @return $this
     */
    public function generateXmlFiles($includedActivities, $filename)
    {
        $this->generator->getMergeXml($includedActivities, $filename);

        return $this;
    }

    /**
     * Save the published files records into the database.
     * @param $filename
     * @param $organizationId
     * @param $includedActivities
     * @return $this
     */
    public function save($filename, $organizationId, $includedActivities)
    {
        $this->generator->savePublishedFiles($filename, $organizationId, $includedActivities);

        return $this;
    }

    /**
     * Validate an Xml file against the schema.
     * @param $activity
     * @param $organizationElement
     * @param $activityElement
     * @return mixed
     */
    public function validate($activity, $organizationElement, $activityElement)
    {
        $organization = $activity->organization;

        return $this->validator->validateActivitySchema($activity, $activity->transactions, $activity->results, $organization->settings, $activityElement, $organizationElement, $organization);
    }

    /**
     * Generate an Activity Xml file.
     * @param $activity
     * @param $organizationElement
     * @param $activityElement
     */
    public function generate($activity, $organizationElement, $activityElement, $unpublish = null)
    {
        $organization = $activity->organization;
        $this->generator->generateActivityXml($activity, $activity->transactions, $activity->results, $organization->settings, $activityElement, $organizationElement, $organization, $unpublish);
    }
}
