<?php

declare(strict_types=1);

namespace App\IATI\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
     * @var array
     */
    protected $casts = [
        'publishing_info' => 'json',
    ];

    /**
     * Setting belongs to organization.
     */
    protected function organization()
    {
        return $this->belongsTo('App\IATI\Models\Organization\Organization', 'organization_id');
    }
}
