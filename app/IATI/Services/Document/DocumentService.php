<?php

declare(strict_types=1);

namespace App\IATI\Services\Setting;

use App\IATI\Repositories\Document\DocumentRepository;

/**
 * Class DocumentService.
 */
class DocumentService
{
    /**
     * @var DocumentRepository
     */
    private $documentRepo;

    /**
     * Sett constructor.
     *
     * @param DocumentRepository $documentRepo
     */
    public function __construct(DocumentRepository $documentRepo)
    {
        $this->documentRepo = $documentRepo;
    }
}
