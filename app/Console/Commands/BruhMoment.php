<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class BruhMoment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:Bruh';

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
    public function handle()
    {
        $newJson = [];
        $loaded = file_get_contents(app_path('IATI/Data/elementJsonSchema.json'));
        foreach (json_decode($loaded, true) as $title =>$element) {
            if (empty(Arr::get($element, 'sub_elements', []))) {
                $newJson[$title] = $element;
            }
        }

        ksort($newJson);

//        $flattenedJson  = flattenArrayWithKeys($newJson);

//        file_put_contents('flattened_bruh_file.json', json_encode($flattenedJson, JSON_PRETTY_PRINT));
        file_put_contents('attr.json', json_encode($newJson, JSON_PRETTY_PRINT));
    }
}
