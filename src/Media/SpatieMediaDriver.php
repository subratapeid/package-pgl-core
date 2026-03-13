<?php

namespace Pgl\Core\Media;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Pgl\Core\Media\Contracts\MediaDriver;
use Pgl\Core\Media\Data\StoredMedia;
use Pgl\Core\Media\Models\MediaAsset;
use RuntimeException;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class SpatieMediaDriver implements MediaDriver
{
    public function upload(UploadedFile $file, array $attributes = []): StoredMedia
    {
        $name = $attributes['name'] ?? Str::of($file->getClientOriginalName())->beforeLast('.')->value();
        $collection = (string) config('pgl-core.media.collection', 'library');
        $disk = (string) config('pgl-core.media.disk', 'media');

        $asset = MediaAsset::query()->create([
            'name' => $name !== '' ? $name : 'Untitled upload',
        ]);

        $media = $asset
            ->addMedia($file)
            ->usingName($asset->name)
            ->toMediaCollection($collection, $disk);

        return $this->map($asset, $media);
    }

    public function all(): array
    {
        return MediaAsset::query()
            ->with('media')
            ->latest()
            ->get()
            ->map(fn (MediaAsset $asset): ?StoredMedia => $this->mapAsset($asset))
            ->filter()
            ->values()
            ->all();
    }

    public function delete(int $assetId): void
    {
        $asset = MediaAsset::query()->findOrFail($assetId);
        $asset->clearMediaCollection(config('pgl-core.media.collection', 'library'));
        $asset->delete();
    }

    private function mapAsset(MediaAsset $asset): ?StoredMedia
    {
        $media = $asset->getFirstMedia(config('pgl-core.media.collection', 'library'));

        if (! $media instanceof Media) {
            return null;
        }

        return $this->map($asset, $media);
    }

    private function map(MediaAsset $asset, Media $media): StoredMedia
    {
        $url = $media->getUrl();

        if ($url === '') {
            throw new RuntimeException('Unable to resolve the media URL.');
        }

        return new StoredMedia(
            assetId: (int) $asset->getKey(),
            mediaId: (int) $media->getKey(),
            name: $asset->name,
            fileName: $media->file_name,
            mimeType: $media->mime_type,
            size: (int) $media->size,
            url: $url,
            collection: $media->collection_name,
            isImage: Str::startsWith((string) $media->mime_type, 'image/'),
            createdAt: $media->created_at?->toDateTimeString() ?? now()->toDateTimeString(),
        );
    }
}