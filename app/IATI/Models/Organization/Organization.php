<?php

declare(strict_types=1);

namespace App\IATI\Models\Organization;

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
        'country',
        'registration_agency',
        'registration_number',
        'identifier',
        'status',
    ];
}
