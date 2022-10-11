<?php
declare(strict_types=1);

use ApiExample\DatabaseInit;
use ApiExample\Registry;
use ApiExample\RegistryKeys;
use ApiExample\Request;

error_reporting(E_ALL);
ini_set('display_errors', 1);

set_error_handler(function (int $severity, string $message, string $filename, int $lineNumber): void {
    throw new ErrorException($message, 0, $severity, $filename, $lineNumber);
});

Registry::set(RegistryKeys::START_TIME, microtime(true));

$db_config = require __DIR__ . '/Config/db_config.php';
$database = new DatabaseInit($db_config['host'], $db_config['dbname'], $db_config['user'], $db_config['password'], $db_config['port']);

Registry::set(RegistryKeys::DATABASE, $database->getPDO());
Registry::set(RegistryKeys::REQUEST, new Request());

