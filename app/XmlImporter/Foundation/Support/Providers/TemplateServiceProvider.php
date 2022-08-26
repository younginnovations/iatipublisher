<?php

namespace App\XmlImporter\Foundation\Support\Providers;

/**
 * Class TemplateServiceProvider.
 */
class TemplateServiceProvider
{
    /**
     * Relative path for the template files.
     *
     * @var string
     */
    protected $relativeTemplatePath = '/XmlImporter/Foundation/Support/Templates';

    /**
     * Template for a specific Xml version.
     *
     * @var null
     */
    protected $template = null;

    /**
     * Get the template for a specific Xml version.
     *
     * @param null $key
     * @return null
     */
    public function get($key = null)
    {
        if (!$key) {
            return $this->template;
        }

        return $this->template[$key];
    }

    /**
     * Load template for a specific version.
     *
     * @param string $version
     * @return array
     */
    public function load($version = 'V202')
    {
        return json_decode($this->read($version), true);
    }

    /**
     * Read the template file.
     *
     * @param $version
     * @return string
     */
    protected function read($version)
    {
        return file_get_contents(sprintf('%s/activity-template.json', $this->templatePath()));
    }

    /**
     * @return string
     */
    protected function templatePath()
    {
        return app_path() . $this->relativeTemplatePath();
    }

    /**
     * Get the relative path for the template files.
     * @return string
     */
    protected function relativeTemplatePath()
    {
        return $this->relativeTemplatePath;
    }
}
