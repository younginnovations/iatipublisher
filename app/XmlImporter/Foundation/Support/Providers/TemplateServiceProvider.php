<?php

declare(strict_types=1);

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
    protected string $relativeTemplatePath = '/XmlImporter/Foundation/Support/Templates';

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
     *
     * @return mixed
     * @throws \JsonException
     */
    public function load(string $version = 'V202'): mixed
    {
        return json_decode($this->read($version), true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * Read the template file.
     *
     * @param $version
     *
     * @return bool|string
     */
    protected function read($version): bool|string
    {
        return file_get_contents(sprintf('%s/activity-template.json', $this->templatePath()));
    }

    /**
     * @return string
     */
    protected function templatePath(): string
    {
        return app_path() . $this->relativeTemplatePath();
    }

    /**
     * Get the relative path for the template files.
     *
     * @return string
     */
    protected function relativeTemplatePath(): string
    {
        return $this->relativeTemplatePath;
    }
}
