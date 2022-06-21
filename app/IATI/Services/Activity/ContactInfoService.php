<?php

declare(strict_types=1);

namespace App\IATI\Services\Activity;

use App\IATI\Repositories\Activity\ContactInfoRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DocumentLink
 *Service.
 */
class ContactInfoService
{
    /**
     * @var ContactInfoRepository
     */
    protected ContactInfoRepository $contactInfoRepository;

    /**
     * ContactInfoService constructor.
     *
     * @param ContactInfoRepository $contactInfoRepository
     */
    public function __construct(ContactInfoRepository $contactInfoRepository)
    {
        $this->contactInfoRepository = $contactInfoRepository;
    }

    /**
     * Returns contact info data of an activity.
     *
     * @param int $activity_id
     *
     * @return array|null
     */
    public function getContactInfoData(int $activity_id): ?array
    {
        return $this->contactInfoRepository->getContactInfoData($activity_id);
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
        return $this->contactInfoRepository->getActivityData($id);
    }

    /**
     * Updates activity country budget item.
     *
     * @param $documentLink
     * @param $activity
     *
     * @return bool
     */
    public function update($documentLink, $activity): bool
    {
        return $this->contactInfoRepository->update($documentLink, $activity);
    }
}
