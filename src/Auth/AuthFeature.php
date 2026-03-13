<?php

namespace Pgl\Core\Auth;

class AuthFeature
{
    public function guard(): string
    {
        return 'web';
    }
}
