<?php
// Configuration de la base de données
define('DB_HOST', 'localhost');
define('DB_NAME', 'USER');
define('DB_USER', 'root');
define('DB_PASS', '');

try {
    $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>
