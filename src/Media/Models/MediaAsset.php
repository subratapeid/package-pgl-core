<?php

namespace Pgl\Core\Media\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class MediaAsset extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'pgl_media_assets';

    protected $fillable = [
        'name',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(config('pgl-core.media.collection', 'library'))
            ->useDisk(config('pgl-core.media.disk', 'media'));
    }
}