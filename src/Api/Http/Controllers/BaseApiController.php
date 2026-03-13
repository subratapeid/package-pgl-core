<?php

namespace Pgl\Core\Api\Http\Controllers;

use Illuminate\Routing\Controller;
use Pgl\Core\Api\Concerns\InteractsWithApiResponses;

abstract class BaseApiController extends Controller
{
    use InteractsWithApiResponses;
}
