<?php

declare(strict_types=1);

namespace App\IATI\Models\Document;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Document.
 */
class Document extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'activity_id',
        'filename',
        'extension',
        'size',
    ];

    /**
     * Document belongs to activity.
     */
    protected function activity()
    {
        return $this->belongsTo('App\IATI\Models\Activity\Activity', 'activity_id');
    }
}
