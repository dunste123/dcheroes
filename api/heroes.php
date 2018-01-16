<?php
if( isset($_GET["team_id"]) && !empty($_GET["team_id"])) {
    require("../php_includes/db.php");
    $k = $db->prepare("SELECT * FROM heroes WHERE TEAM_ID=:id");
    $k->execute([
        "id" => $_GET["team_id"]
    ]);
    die( json_encode($k->fetchAll(PDO::FETCH_ASSOC), JSON_PRETTY_PRINT));
} else {
    require("../php_includes/db.php");
    die( json_encode($db->query("SELECT * FROM heroes WHERE 1")->fetchAll(PDO::FETCH_ASSOC), JSON_PRETTY_PRINT));
}
