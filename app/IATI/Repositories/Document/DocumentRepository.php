<?php

declare(strict_types=1);

namespace App\IATI\Repositories\Document;

use App\IATI\Models\Document\Document;
use App\IATI\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DocumentRepository.
 */
class DocumentRepository extends Repository
{
    /**
     * Get model name with namespace.
     *
     * @return string
     */
    public function getModel(): string
    {
        return Document::class;
    }

    /**
     * Update or create document link.
     *
     * @return mixed
     */
    public function updateOrCreateDocument($filename, $activity_id, $data): mixed
    {
        return $this->model->updateOrCreate(['filename' => $filename, 'activity_id' => $activity_id], $data);
    }

    /**
     * Inserts multiple documents.
     *
     * @param $documents
     *
     * @return bool
     */
    public function insert($documents): bool
    {
        return $this->model->insert($documents);
    }
}
