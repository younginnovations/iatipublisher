<?php

declare(strict_types=1);

namespace App\IATI\Models\Activity;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Indicator.
 */
class Indicator extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    /**
     * @var string
     */
    protected $table = 'activity_result_indicators';

    /**
     * @var array
     */
    protected $fillable = [
        'result_id',
        'indicator',
        'created_at',
        'updated_at',
        'migrated_from_aidstream',
        'indicator_code',
        'deprecation_status_map',
    ];

    /**
     * @var array
     */
    protected $casts
        = [
            'indicator' => 'json',
            'deprecation_status_map' => 'json',
        ];

    /**
     * Updates timestamp of result on result indicator.
     *
     * @var array
     */
    protected $touches = ['result'];

    /**
     * Before inbuilt function.
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        static::saving(
            function ($model) {
                if (!$model->indicator_code) {
                    $model->indicator_code = Auth::user() ? sprintf('%d%s', Auth::user()->id, time()) : sprintf('%d%s', $model->id, time());
                }
            }
        );
    }

    /**
     * Indicator hasmany periods.
     *
     * @return HasMany
     */
    public function periods(): HasMany
    {
        return $this->hasMany(Period::class, 'indicator_id', 'id');
    }

    /**
     * Result belongs to activity.
     *
     * @return BelongsTo
     */
    public function result(): BelongsTo
    {
        return $this->belongsTo(Result::class, 'result_id', 'id');
    }

    /**
     * Returns default title narrative.
     *
     * @return string|null
     */
    public function getDefaultTitleNarrativeAttribute(): string|null
    {
        $indicator = $this->indicator;
        $titles = $indicator['title'];

        if (!empty($titles)) {
            foreach ($titles as $title) {
                if (array_key_exists('narrative', $title)) {
                    $narratives = $title['narrative'];

                    foreach ($narratives as $narrative) {
                        if (array_key_exists('language', $narrative) && !empty($narrative['language']) && $narrative['language'] === getDefaultLanguage($this->result->activity->default_field_values)) {
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
