<?php

namespace App\Console\Commands;

use App\IATI\Models\Activity\ActivityPublished;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SetAllPublisherPublishedFileSizes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:SetAllPublisherPublishedFileSizes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        ActivityPublished::chunk(50, function ($activityPublishedChunk) {
            DB::beginTransaction();

            try {
                foreach ($activityPublishedChunk as $activityPublished) {
                    $this->info("Started for org_id: $activityPublished->organization_id");
                    $filename = $activityPublished->filename;
                    $xmlString = awsGetFile("xml/mergedActivityXml/$filename");
                    $fileSize = $xmlString ? calculateStringSizeInMb($xmlString) : 0;

                    $activityPublished->filesize = $fileSize;
                    $activityPublished->save();
                    $this->info("Completed for org_id: $activityPublished->organization_id");
                }

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();

                $this->error('Error updating activity published file sizes: ' . $e->getMessage());
            }
        });
    }
}
