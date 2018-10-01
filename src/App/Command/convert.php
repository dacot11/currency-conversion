<?php

require 'vendor/autoload.php';

use App\Db\RateDAO;
use App\Converter\Converter;

// TODO: Create help for command.

$config = include 'config/config.php';

$dsn = "mysql:host={$config['host']};dbname={$config['dbName']};charset={$config['charset']}";

$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
try {
    $pdo = new PDO($dsn, $config['user'], $config['pass'], $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

if (count($argv) <= 1) {
    print("Please provide a currency and value in the format: \"<Currency> <value>\". Ex: \"JPY 5000\"\n");
    exit(0);
}

// Build the Converter and dependencies.
$rateDAO = new RateDAO($pdo);
$converter = new Converter($rateDAO);

// Remove the first, `file name`, argument form the list of arguments.
\array_shift($argv);

foreach($argv as $convTuple) {
    convertOne($convTuple, $converter);
}


$pdo = null;
exit(0);

function convertOne($convTuple, $converter) {
    $convData = \explode(" ", $convTuple);

    if (!$convData || count($convData) != 2) {
        print("Please provide a currency and value in the format: \"<Currency> <value>\". Ex: \"JPY 5000\"\n");
        return;
    }

    $currency = \strtoupper((string) $convData[0]);
    $value = (float) $convData[1];

    $conversion = $converter->convert($currency, $value);

    // TODO: Handle convertion errors for a better feedback.
    if ($conversion != null) {
        printf("{$currency} {$value} => USD {$conversion}\n");
    } else {
        print("Could not convert.\n");
    }
}

