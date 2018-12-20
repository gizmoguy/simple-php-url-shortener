<?php
// db options
$dsn  = "pgsql:host=localhost;dbname=urlshort";
$user = "urlshort";
$pass = "urlshort";

$pdo_options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// connect to database
try {
   $pdo = new PDO($dsn, $user, $pass, $pdo_options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// base location of script (include trailing slash)
define('BASE_HREF', 'http://' . $_SERVER['HTTP_HOST'] . '/' );
