<?php
require('../php_includes/db.php');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

if( isset($_GET['team_id']) && !empty($_GET['team_id'])) {
    $k = $db->prepare('SELECT * FROM heroes WHERE TEAM_ID=:id');
    $k->execute([
        'id' => $_GET['team_id']
    ]);
    die( json_encode($k->fetchAll(PDO::FETCH_ASSOC), JSON_PRETTY_PRINT));
} else {
    die( json_encode($db->query('SELECT * FROM heroes')->fetchAll(PDO::FETCH_ASSOC), JSON_PRETTY_PRINT));
}
