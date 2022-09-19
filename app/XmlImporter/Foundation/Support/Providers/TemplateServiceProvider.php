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
     * @return array
     */
    public function load(): mixed
    {
        return json_decode($this->read($version), true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * Read the template file.
     *
     * @return bool|string
     */
    protected function read(): bool|string
    {
        return file_get_contents(sprintf('%s/activity-template.json', $this->templatePath()));
    }

    /**
     * Returns xml template path.
     *
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
