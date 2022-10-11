<?php

declare(strict_types=1);

use ApiExample\Routing\Router;
use ApiExample\Exceptions\NotFoundException;

try {
    require __DIR__ . '/src/Config/app_config.php';
    require __DIR__ . '/vendor/autoload.php';
    require __DIR__ . '/src/bootstrap.php';
    require __DIR__ . '/src/routes.php';

    Router::start();

} catch (NotFoundException $e) {
    header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found', true, 404);
    echo '404 error';
} catch (\ApiExample\Exceptions\AppException $e) {
    echo 'App error: ' . $e->getMessage();
} catch (Exception|Error $e) {
    if (isset($_SERVER["SERVER_PROTOCOL"])) {
        header($_SERVER["SERVER_PROTOCOL"] . ' 500 Internal Server Error', true, 500);
    }
    if (SHOW_ERRORS) {
        if (isset($e->xdebug_message)) {
            echo "500 Internal Server Error<br><font size='1'><table dir='ltr' border='1' cellspacing='0' cellpadding='1'>" . $e->xdebug_message . "</table>";
        } else {
            echo "500 Internal Server Error:" . $e->getMessage();
        }
    } else {
        echo 'Internal Server Error occurred';
    }
}







