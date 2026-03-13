<?php

namespace Pgl\Core\Admin\Actions\Media;

use Pgl\Core\Admin\Services\MediaLibraryService;

class DeleteMediaAction
{
    public function __construct(
        private readonly MediaLibraryService $mediaLibraryService,
    ) {
    }

    public function __invoke(int $assetId): void
    {
        $this->mediaLibraryService->delete($assetId);
    }
}