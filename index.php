<?php
require("php_includes/db.php");
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_GET["rate"])) {
    $insert = $db->prepare("
    INSERT INTO rating
    VALUES (
      DEFAULT ,
      :hero_id ,
      :rating , 
      :rating_date , 
      :ratingReview
    )
    ");
    $insert->execute([
        "hero_id" => $_GET['hero_id'],
        "rating" => $_POST["rating"],
        "rating_date" => strftime("%d%m%G"),
        "ratingReview" => $_POST["ratingReview"]
    ]);
}

function getCorrectHeroFromGetVariable() {
    if(isset($_GET['hero_id']) && !empty($_GET['hero_id'])) {
        if($_GET['hero_id'] == -1) {
            global $db;
            $smt = $db->prepare("SELECT HERO_ID FROM heroes WHERE TEAM_ID=:id LIMIT 1");
            $smt->execute([
                'id' => isset($_GET['team_id']) && !empty($_GET['team_id']) ? $_GET['team_id'] : 1
            ]);
            return $smt->fetchAll(PDO::FETCH_OBJ)[0]->HERO_ID;
        } else {
            return $_GET["hero_id"];
        }
    } else
        return 1;
}
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="css/stars.css" />
        <link rel="stylesheet" href="css/style.css" />

        <link href="img/icon/favicon.png" rel="icon" />
        <link href="img/icon/favicon.png" rel="shortcut icon" />
        <link href="img/icon/favicon.png" rel="apple-touch-icon" />

        <title>DC Heros</title>
    </head>
    <body>

        <header id="header">
            <div class="logo">
                <a href="/" class='nicefont'><img src="img/icon/transparent.png" />Heroes</a>
            </div>
        </header>

        <main id="main-container">

            <div class="col" id="main-left">
                <h1 class='nicefont'>Teams</h1>
                <nav>
                    <ul class='teambtn'>
                        <?php
                        $teams = $db->query("SELECT * FROM teams WHERE VISABLE = 1")->fetchAll(PDO::FETCH_OBJ);
                        foreach($teams as $team) {
                            $hero_count = $db->query("SELECT COUNT(HERO_ID) AS HERO_COUNT FROM heroes WHERE TEAM_ID=$team->TEAM_ID")->fetchAll(PDO::FETCH_OBJ)[0];
                            echo "<li class='btn' onclick='window.location.replace(\"?team_id=$team->TEAM_ID&hero_id=-1\")'><a href='?team_id=$team->TEAM_ID&hero_id=-1'>$team->TEAM_NAME ($hero_count->HERO_COUNT)</a></li>";
                        }
                        ?>
                    </ul>
                </nav>
            </div>

            <div class="col" id="main-center">
                <?php /*$things = $db->prepare("SELECT * FROM heroes WHERE TEAM_ID=:id");
                $things->execute([
                    'id' => isset($_GET['team_id']) && !empty($_GET['team_id']) ? $_GET['team_id'] : 1
                ]);
                $things = $things->fetchAll(PDO::FETCH_OBJ);
                foreach ($things as $hero) {
                    echo "<div class='hero'>
                            <div class='image'>
                                <img src='" . str_replace("\\", "/", $hero->HERO_IMAGE) . "' />
                            </div>
                            <div class='description'>
                                <h3 class='nicefont'>$hero->HERO_NAME</h3>
                                <p>$hero->HERO_DESCRIPTION</p>
                                <a class='btn' href='?team_id=$hero->TEAM_ID&hero_id=$hero->HERO_ID' onclick='getHeroById($hero->HERO_ID);return false;'>Read more</a>
                            </div>
                            <div class='clearfix'></div>
                          </div>";
                }*/
                ?>
            </div>

            <div class="col" id="main-right">LOADING....</div>

        </main>
        <script src="https://use.fontawesome.com/3ae13c09d4.js"></script>
        <script src="js/getHero.js"></script>
        <script>
            getHeroById(<?php echo getCorrectHeroFromGetVariable(); ?>);
            getHeroesForTeam(<?php echo isset($_GET['team_id']) && !empty($_GET['team_id']) ? $_GET['team_id'] : 1; ?>);
        </script>
    </body>
</html>