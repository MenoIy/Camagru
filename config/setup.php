<?php
include 'database.php';
require '../core/Database.php';


$db = new Database();
$statement = file_get_contents('db.sql');
$db->execute($statement, ['']);
$db->close();
echo "database created\n";

?>