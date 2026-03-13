<?php

namespace Pgl\Core\Admin\Actions\Media;

use Illuminate\Http\UploadedFile;
use Pgl\Core\Admin\Services\MediaLibraryService;
use Pgl\Core\Media\Data\StoredMedia;

class UploadMediaAction
{
    public function __construct(
        private readonly MediaLibraryService $mediaLibraryService,
    ) {
    }

    public function __invoke(UploadedFile $file, ?string $name = null): StoredMedia
    {
        return $this->mediaLibraryService->upload($file, $name);
    }
}