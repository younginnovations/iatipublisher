<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Organization;

use App\IATI\Models\Organization\Organization;
use App\IATI\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrganizationRepository.
 */
class OrganizationRepository extends Repository
{
    /**
     * Return Organization model.
     *
     * @return string
     */
    public function getModel(): string
    {
        return Organization::class;
    }

    /**
     * Creates new organization.
     *
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|mixed
     */
    public function createOrganization(array $data): mixed
    {
        return $this->model->updateOrCreate(['publisher_id' => $data['publisher_id']], $data);
    }

    /**
     * Returns organization object.
     *
     * @param $id
     *
     * @return Model
     */
    public function getOrganizationData($id): Model
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Updates status column of activity row.
     *
     * @param $organization
     * @param $status
     * @param $alreadyPublished
     * @param $linkedToIati
     *
     * @return bool
     */
    public function updatePublishedStatus($organization, $status, $alreadyPublished, $linkedToIati): bool
    {
        $organization->status = $status;
        $organization->is_published = $alreadyPublished;

        return $organization->save();
    }
}
