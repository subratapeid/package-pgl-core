<?php

namespace Pgl\Core\Media;

use Illuminate\Http\UploadedFile;
use Pgl\Core\Media\Contracts\MediaDriver;
use Pgl\Core\Media\Data\StoredMedia;

class MediaManager
{
    public function __construct(
        private readonly MediaDriver $mediaDriver,
    ) {
    }

    /**
     * @param array<string, mixed> $attributes
     */
    public function upload(UploadedFile $file, array $attributes = []): StoredMedia
    {
        return $this->mediaDriver->upload($file, $attributes);
    }

    /**
     * @return array<int, StoredMedia>
     */
    public function all(): array
    {
        return $this->mediaDriver->all();
    }

    public function delete(int $assetId): void
    {
        $this->mediaDriver->delete($assetId);
    }
}