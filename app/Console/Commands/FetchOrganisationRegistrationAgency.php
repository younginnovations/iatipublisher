<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use JsonException;
use PHPUnit\Exception;

/**
 * Used in cronjob to run every day at 12:00 AM.
 *
 * @class FetchOrganisationRegistrationAgency
 */
class FetchOrganisationRegistrationAgency extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:FetchOrganisationRegistrationAgency';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches and creates new app/Data/Organization/OrganizationRegistrationAgency.json daily.';

    /**
     * Execute the console command.
     *
     * @return void
     *
     * @throws JsonException
     */
    public function handle()
    {
        try {
            $this->info('Attempting to fetch from org-id website...');
            logger()->info('Attempting to fetch from org-id website...');

            $endpoint = 'http://org-id.guide/download.json';
            $response = Http::get($endpoint);

            $this->info('Attempting to write new json...');
            logger()->info('Attempting to write new json...');

            if ($response->successful()) {
                $jsonValue = $response->json()['lists'];
                $iatiJsonValues = collect($jsonValue)
                    ->filter(fn ($rawJson) => !isset($rawJson['deprecated']) || !$rawJson['deprecated'])
                    ->map(fn ($rawJson) => $this->parseToIatiOrganisationRegistrationAgencyJson($rawJson))
                    ->all();

                $newJson = [
                    'date-last-modified'             => now(),
                    'version'                        => '',
                    'name'                           => 'OrganizationRegistrationAgency',
                    'xml:lang'                       => 'en',
                    'OrganizationRegistrationAgency' => array_values($iatiJsonValues),
                ];

                $newJsonString = json_encode($newJson, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                $filePath = 'app/Data/Organization/OrganizationRegistrationAgency.json';

                file_put_contents($filePath, $newJsonString);
            }

            $this->info('Completed.');
            logger()->info('Completed.');
        } catch (Exception $e) {
            logger()->error($e);
        }
    }

    public function parseToIatiOrganisationRegistrationAgencyJson($data): array
    {
        $category = $data['coverage'][0] ?? '';
        $status = isset($data['deprecated']) && $data['deprecated'] === false ? 'active' : null;

        return [
            'code'            => data_get($data, 'code', ''),
            'category'        => $category,
            'url'             => data_get($data, 'url', ''),
            'name'            => data_get($data, 'name.en', ''),
            'description'     => data_get($data, 'description.en', ''),
            'public-database' => data_get($data, 'access.publicDatabase', ''),
            'status'          => $status,
        ];
    }
}
