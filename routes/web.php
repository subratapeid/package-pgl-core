<?php

$adminRoutes = __DIR__.'/admin.php';
$storefrontRoutes = __DIR__.'/storefront.php';

if (is_file($adminRoutes)) {
    require $adminRoutes;
}

if (is_file($storefrontRoutes)) {
    require $storefrontRoutes;
}