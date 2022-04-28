<?php

declare(strict_types=1);

namespace App\IATI\Models\Organization;

use App\IATI\Models\Activity\Activity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User.
 */
class Organization extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'publisher_id',
        'publisher_name',
        'publisher_type',
        'identifier',
        'name',
        'address',
        'telephone',
        'reporting_org',
        'country',
        'logo_url',
        'organization_url',
        'status',
        'is_published',
        'registration_agency',
        'registration_number',
    ];

    /**
     * @var array
     */
    protected $casts = ['reporting_org' => 'json'];

    /**
     * Organisation has many activities.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Activity::class, 'org_id');
    }
}
