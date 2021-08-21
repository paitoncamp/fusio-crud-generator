<?php

require_once(__DIR__ . '/vendor/autoload.php');

use Doctrine\DBAL\DriverManager;

$connectionParams = array(
    'dbname' => 'mysql',
    'user' => 'root',
    'password' => '',
    'host' => 'localhost',
    'driver' => 'pdo_mysql',
);

$connection = DriverManager::getConnection($connectionParams);


