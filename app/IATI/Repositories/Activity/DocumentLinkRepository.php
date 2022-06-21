<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Activity;

use App\IATI\Models\Activity\Activity;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DocumentLinkRepository.
 */
class DocumentLinkRepository
{
    /**
     * @var Activity
     */
    protected Activity $activity;

    /**
     * DocumentLinkRepository Constructor.
     *
     * @param Activity $activity
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    /**
     * Returns document info data of an activity.
     *
     * @param $activityId
     *
     * @return array|null
     */
    public function getDocumentLinkData($activityId): ?array
    {
        return $this->activity->findorFail($activityId)->document_link;
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
        return $this->activity->findOrFail($id);
    }

    /**
     * Updates activity document link.
     *
     * @param $documentLink
     * @param $activity
     *
     * @return bool
     */
    public function update($documentLink, $activity): bool
    {
        $element = json_decode(file_get_contents(app_path('IATI/Data/elementJsonSchema.json')), true)['document-link'];

        foreach (array_keys($element['sub_elements']) as $subelement) {
            $documentLink[$subelement] = array_values($documentLink[$subelement]);
        }

        $activity->document_link = $documentLink;

        return $activity->save();
    }
}
