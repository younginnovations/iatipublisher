<?php

declare(strict_types=1);

namespace App\IATI\Models\Organization;

use Illuminate\Database\Eloquent\Model;

/**
 * Class User.
 */
class Organization extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
      'publisher_id',
      'publisher_type',
      'country',
      'registration_agency',
      'registration_number',
      'identifier',
      'status',
    ];
}
