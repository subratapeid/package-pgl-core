<?php

namespace Pgl\Core\AccessControl\Contracts;

interface PermissionGateway
{
    public function allows(string $permission, mixed $subject = null): bool;
}
