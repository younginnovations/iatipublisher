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
}
