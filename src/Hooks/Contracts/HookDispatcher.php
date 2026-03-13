<?php

namespace Pgl\Core\Hooks\Contracts;

interface HookDispatcher
{
    public function dispatch(string $hook, mixed $payload = null): mixed;
}
