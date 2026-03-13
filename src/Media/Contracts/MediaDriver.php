<?php

namespace Pgl\Core\Media\Contracts;

use Illuminate\Http\UploadedFile;
use Pgl\Core\Media\Data\StoredMedia;

interface MediaDriver
{
    /**
     * @param array<string, mixed> $attributes
     */
    public function upload(UploadedFile $file, array $attributes = []): StoredMedia;

    /**
     * @return array<int, StoredMedia>
     */
    public function all(): array;

    public function delete(int $assetId): void;
}