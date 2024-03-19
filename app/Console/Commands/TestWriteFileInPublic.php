<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestWriteFileInPublic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:TestWriteFileInPublic
';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test write to public via cron.s';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        logger('TestWriteFileInPublic fired');

        $createDate = now()->format('Y_m_d_H_i_s');
        $content = json_encode([
            'message' => 'File written by command:TestWriteFileInPublic',
            'time' => $createDate,
        ], JSON_THROW_ON_ERROR);

        $filename = "WRITE_$createDate.json";

        $path = public_path('AppData/' . $filename);
        $count = file_put_contents($path, $content);

        logger('Path being written at: ' . $path);
        logger("$count after writing: " . $count);
    }
}
