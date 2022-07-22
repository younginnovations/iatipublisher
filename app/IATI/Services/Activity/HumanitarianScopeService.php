<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Models\Activity\Activity;
use App\IATI\Repositories\Activity\HumanitarianScopeRepository;
use App\IATI\Traits\XmlBaseElement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * Class HumanitarianScopeService.
 */
class HumanitarianScopeService
{
    use XmlBaseElement;

    /**
     * @var HumanitarianScopeRepository
     */
    protected HumanitarianScopeRepository $humanitarianScopeRepository;

    /**
     * HumanitarianScopeService constructor.
     *
     * @param HumanitarianScopeRepository $humanitarianScopeRepository
     */
    public function __construct(HumanitarianScopeRepository $humanitarianScopeRepository)
    {
        $this->humanitarianScopeRepository = $humanitarianScopeRepository;
    }

    /**
     * Returns humanitarian scope data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getHumanitarianScopeData(int $activity_id): ?array
    {
        return $this->humanitarianScopeRepository->getHumanitarianScopeData($activity_id);
    }

    /**
     * Returns activity object.
     *
     * @param $id
     *
     * @return Model
     */
    public function getActivityData($id): Model
    {
        return $this->humanitarianScopeRepository->getActivityData($id);
    }

    /**
     * Updates activity humanitarian scope.
     *
     * @param $activityHumanitarianScope
     * @param $activity
     *
     * @return bool
     */
    public function update($activityHumanitarianScope, $activity): bool
    {
        return $this->humanitarianScopeRepository->update($activityHumanitarianScope, $activity);
    }

    /**
     * Returns data in required xml array format.
     *
     * @param Activity $activity
     *
     * @return array
     */
    public function getXmlData(Activity $activity): array
    {
        $activityHumanitarianScope = [];
        $humanitarianScopes = (array) $activity->humanitarian_scope;

        foreach ($humanitarianScopes as $humanitarianScope) {
            $activityHumanitarianScope[] = [
                '@attributes' => [
                    'type'           => Arr::get($humanitarianScope, 'type', null),
                    'vocabulary'     => Arr::get($humanitarianScope, 'vocabulary', null),
                    'vocabulary-uri' => Arr::get($humanitarianScope, 'vocabulary_uri', null),
                    'code'           => Arr::get($humanitarianScope, 'code', null),
                ],
                'narrative'   => $this->buildNarrative(Arr::get($humanitarianScope, 'narrative', null), ),
            ];
        }

        return $activityHumanitarianScope;
    }
}
