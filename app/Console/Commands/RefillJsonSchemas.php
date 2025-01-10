<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;

/**
 * @class RefillJsonSchemas
 */
class RefillJsonSchemas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:RefillJsonSchemas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->rewriteJsonSchema(
            app_path('IATI/Data/elementJsonSchema.json'),
            public_path('Help and Hover texts (ODS reviewed) - Activity Help and Hover Text.csv')
        );

        $this->rewriteJsonSchema(
            app_path('IATI/Data/organizationElementJsonSchema.json'),
            public_path('Help and Hover texts (ODS reviewed) - Organisation Help and Hover Text.csv')
        );

        return 0;
    }

    /**
     * General method to rewrite JSON schemas.
     *
     * @param string $jsonSchemaPath
     * @param string $csvFilePath
     *
     * @return void
     */
    private function rewriteJsonSchema(string $jsonSchemaPath, string $csvFilePath): void
    {
        $jsonSchema = json_decode(file_get_contents($jsonSchemaPath), true);
        $csvData = collect(array_map('str_getcsv', file($csvFilePath)));

        $csvData = $csvData->slice(1);

        $csvData->each(function ($row) use (&$jsonSchema) {
            if (count($row) >= 3) {
                $accessKey = $row[0];
                $newValue = $row[2];

                Arr::set($jsonSchema, $accessKey, $newValue);
            }
        });

        $jsonOutput = json_encode($jsonSchema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_FORCE_OBJECT);

        // This is so that I get minimal git changes. If indent = 4, the entire file will be shown as changed.
        // Ideally only help_text and hover_text should have been changed
        $jsonOutput = str_replace('    ', '  ', $jsonOutput);

        file_put_contents($jsonSchemaPath, $jsonOutput);

        $this->info("JSON schema at {$jsonSchemaPath} updated successfully.");
    }
}
