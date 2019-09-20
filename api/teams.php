<?php
require('../php_includes/db.php');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$dbTeams = $db->query("
    SELECT t.TEAM_ID, t.TEAM_NAME, (
        SELECT COUNT(h.HERO_ID) FROM heroes as h WHERE h.TEAM_ID = t.TEAM_ID
    ) as 'COUNT'
    FROM teams AS t
    WHERE t.VISABLE=1
")->fetchAll(PDO::FETCH_ASSOC);

die(
    json_encode($dbTeams, JSON_PRETTY_PRINT)
);
