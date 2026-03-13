<?php

namespace Pgl\Core\Audit\Contracts;

interface ActivityLogger
{
    /**
     * @param array<string, mixed> $context
     */
    public function log(string $event, array $context = []): void;
}
