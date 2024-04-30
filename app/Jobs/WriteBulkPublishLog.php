<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Write the information to log in AWS S3.
 */
class WriteBulkPublishLog implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public $process, public string $content, public string $type, public bool $newLine)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $fileContent = awsGetFile('BulkPublishTesting/bulk-publish-info.json');
            $data = $fileContent ? json_decode($fileContent, true, 512, JSON_THROW_ON_ERROR) : [];

            if ($this->type === 'info') {
                logger()->info($this->content);
                $data[$this->process][] = 'Info: ' . $this->content;
            } else {
                logger()->error($this->content);
                $data[$this->process][] = 'Error: ' . $this->content;
            }

            if ($this->newLine) {
                $data[$this->process][] = '';
            }

            awsUploadFile('BulkPublishTesting/bulk-publish-info.json', json_encode($data, JSON_THROW_ON_ERROR));
        } catch (\Exception $e) {
            logger()->error($e);
        }
    }
}
