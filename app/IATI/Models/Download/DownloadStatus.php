<?php

namespace App\IATI\Models\Download;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DownloadStatus.
 */
class DownloadStatus extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'download_status';

    /**
     * @var array
     */
    protected $fillable = [
        'status',
        'file_count',
        'user_id',
        'type',
        'url',
    ];
}
