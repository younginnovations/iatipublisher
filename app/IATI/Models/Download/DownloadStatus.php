<?php

declare(strict_types=1);

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
     * Table name mentioned in migration.
     *
     * @var string
     */
    protected $table = 'download_status';

    /**
     * Mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'file_count',
        'user_id',
        'type',
        'url',
        'selected_activities',
    ];

    /**
     * Casting attributes to data types.
     *
     * @var string[]
     */
    protected $casts = [
        'selected_activities' => 'json',
    ];
}
