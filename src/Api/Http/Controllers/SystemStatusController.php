<?php

namespace Pgl\Core\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;

class SystemStatusController extends BaseApiController
{
    public function __invoke(): JsonResponse
    {
        return $this->success([
            'name' => config('app.name'),
            'package' => 'pgl/core',
            'version' => config('pgl-core.routing.api_version'),
            'status' => 'ok',
        ]);
    }
}