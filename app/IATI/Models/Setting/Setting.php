<?php

declare(strict_types=1);

namespace App\IATI\Models\Setting;

use App\IATI\Models\Organization\Organization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Setting.
 */
class Setting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'organization_id',
        'publishing_info',
        'default_values',
        'activity_default_values',
    ];

    /**
     * @return BelongsTo
     */
    protected function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }
}
