<?php
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$routes = $app['router']->getRoutes();
$route = $routes->getByName('admin.recharge.index');
if ($route) {
    echo "OK: admin.recharge.index -> " . $route->uri() . "\n";
} else {
    echo "FAIL: admin.recharge.index not found\n";
}
