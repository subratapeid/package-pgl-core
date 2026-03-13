<?php

namespace Pgl\Core\Settings\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'pgl_settings';

    protected $fillable = [
        'group',
        'key',
        'value',
    ];
}
