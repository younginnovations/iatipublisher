<?php

namespace App\Console\Commands;

use App\IATI\Traits\IatiValidatorResponseTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ReformatOldResponseData extends Command
{
    use IatiValidatorResponseTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'format:validator-response';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It reformat old iati validator response to new one';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::table('iati_validator_responses')->chunkById(10, function ($responses) {
            foreach ($responses as $validatorResponse) {
                $response = json_decode($validatorResponse->response, true);
                if (isset($response['errors'][0]['response'])) {
                    continue;
                }

                $errors = $response['errors'];

                foreach ($errors as $errorKey => $error) {
                    $response['errors'][$errorKey]['response'][0]['iati_path'] = "/activity/$validatorResponse->activity_id";
                    $response['errors'][$errorKey]['response'][0]['message'] = "activity > $validatorResponse->activity_id";
                }

                DB::table('iati_validator_responses')->where('id', $validatorResponse->id)->update(['response' => json_encode($response)]);
            }
        });
    }
}
