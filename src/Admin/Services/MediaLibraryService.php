<?php

namespace Pgl\Core\Admin\Services;

use Illuminate\Http\UploadedFile;
use Pgl\Core\Media\Data\StoredMedia;
use Pgl\Core\Media\MediaManager;

class MediaLibraryService
{
    public function __construct(
        private readonly MediaManager $mediaManager,
    ) {
    }

    /**
     * @return array<int, StoredMedia>
     */
    public function all(): array
    {
        return $this->mediaManager->all();
    }

    public function upload(UploadedFile $file, ?string $name = null): StoredMedia
    {
        return $this->mediaManager->upload($file, [
            'name' => $name,
        ]);
    }

    public function delete(int $assetId): void
    {
        $this->mediaManager->delete($assetId);
    }
}