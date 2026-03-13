<?php

namespace Pgl\Core\Media\Data;

readonly class StoredMedia
{
    public function __construct(
        public int $assetId,
        public int $mediaId,
        public string $name,
        public string $fileName,
        public ?string $mimeType,
        public int $size,
        public string $url,
        public string $collection,
        public bool $isImage,
        public string $createdAt,
    ) {
    }
}