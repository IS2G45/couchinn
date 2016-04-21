<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

echo 'starting...';
$db = new SQLite("db/couchinn_db");

echo 'lallala';die();

$db = sqlite_open('db/couchinn_db', 0666, $error);


echo 'finifhing...';

echo var_dump($db); die();

$results = $bd->query('SELECT nombre FROM prueba');
while ($row = $results->fetchArray()) {
    var_dump($row);
}
echo 'lalala';
?>
