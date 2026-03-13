<?php

namespace Pgl\Core\Seo\Contracts;

interface SeoManager
{
    /**
     * @param array<string, mixed> $payload
     */
    public function apply(array $payload = []): void;
}
