<?php

require 'vendor/autoload.php';

use App\Db\RateDAO;
use App\Converter\Loader;

// TODO: Create help for command.

$config = include 'config/config.php';

$dsn = "mysql:host={$config['host']};dbname={$config['dbName']};charset={$config['charset']}";

$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
try {
    $pdo = new PDO($dsn, $config['user'], $config['pass'], $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Build the Loader and dependencies.
$rateDAO = new RateDAO($pdo);
$loader = new Loader($rateDAO);

$loader->load($config['ratesAPIURL']);

$pdo = null;
exit(0);
