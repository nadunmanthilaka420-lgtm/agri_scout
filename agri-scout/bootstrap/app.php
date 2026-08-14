<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    putenv('PATH=C:\\oracle\\instantclient_23_26;C:\\xampp\\php;' . getenv('PATH'));
}

// Compatibility constant aliases for Yajra OCI8 on PHP 8.4/8.5+
if (!defined('Yajra\Pdo\OCI_DEFAULT')) {
    define('Yajra\Pdo\OCI_DEFAULT', defined('\OCI_DEFAULT') ? \OCI_DEFAULT : (defined('\OCI_NO_AUTO_COMMIT') ? \OCI_NO_AUTO_COMMIT : 0));
}
if (!defined('Yajra\Pdo\Oci8\OCI_DEFAULT')) {
    define('Yajra\Pdo\Oci8\OCI_DEFAULT', defined('\OCI_DEFAULT') ? \OCI_DEFAULT : (defined('\OCI_NO_AUTO_COMMIT') ? \OCI_NO_AUTO_COMMIT : 0));
}
if (!defined('Yajra\Pdo\Oci8\OCI_COMMIT_ON_SUCCESS')) {
    define('Yajra\Pdo\Oci8\OCI_COMMIT_ON_SUCCESS', defined('\OCI_COMMIT_ON_SUCCESS') ? \OCI_COMMIT_ON_SUCCESS : 32);
}

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
