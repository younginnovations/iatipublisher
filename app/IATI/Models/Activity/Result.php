<?php

declare(strict_types=1);

namespace App\IATI\Models\Activity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Result.
 */
class Result extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    /**
     * @var string
     */
    protected $table = 'activity_results';

    /**
     * Fillable property for mass assignment.
     *
     * @var array
     */
    protected $fillable
    = [
        'activity_id',
        'result',
        'migrated_from_aidstream',
        'created_at',
        'updated_at',
    ];

    /**
     * @var array
     */
    protected $casts
        = [
            'result' => 'json',
        ];

    protected $touches = ['activity'];

    /**
     * Result belongs to activity.
     *
     * @return BelongsTo
     */
    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class, 'activity_id', 'id');
    }

    /**
     * Result hasmany indicators.
     *
     * @return HasMany
     */
    public function indicators(): HasMany
    {
        return $this->hasMany(Indicator::class, 'result_id', 'id');
    }

    /**
     * Returns default title.
     *
     * @return string|null
     */
    public function getDefaultTitleNarrativeAttribute(): string|null
    {
        $result = $this->result;
        $titles = $result['title'];

        if (!empty($titles)) {
            foreach ($titles as $title) {
                if (array_key_exists('narrative', $title)) {
                    $narratives = $title['narrative'];

                    foreach ($narratives as $narrative) {
                        if (array_key_exists(
                            'language',
                            $narrative
                        ) && !empty($narrative['language']) && $narrative['language'] === getDefaultLanguage(
                            $this->activity->default_field_values
                        )) {
                            return $narrative['narrative'];
                        }
                    }

                    return array_key_exists('narrative', $narratives[0]) ? $narratives[0]['narrative'] : '';
                }
            }
        }

        return '';
    }
}
