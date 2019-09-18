<?php
require("../php_includes/db.php");
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
die(
    json_encode(
        $db->query("SELECT TEAM_ID, TEAM_NAME FROM teams WHERE VISABLE=1")->fetchAll(PDO::FETCH_ASSOC),
        JSON_PRETTY_PRINT
    )
);
