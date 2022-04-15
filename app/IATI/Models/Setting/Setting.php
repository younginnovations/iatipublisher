<?php

declare(strict_types=1);

namespace App\IATI\Models\Setting;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Setting.
 */
class Setting extends Model
{
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
}
