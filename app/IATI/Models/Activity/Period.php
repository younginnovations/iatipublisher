<?php

declare(strict_types=1);

namespace App\IATI\Models\Activity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Period.
 */
class Period extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'result_indicator_periods';

    /**
     * @var array
     */
    protected $fillable
    = [
        'indicator_id',
        'period',
    ];

    /**
     * @var array
     */
    protected $casts
    = [
        'period' => 'json',
    ];
}
