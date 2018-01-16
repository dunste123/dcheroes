<?php
require("../php_includes/db.php");
$things = $db->prepare("SELECT * FROM heroes WHERE HERO_ID=:id LIMIT 1");
$things->execute([
    'id' => isset($_POST['hero_id']) && !empty($_POST['hero_id']) ? $_POST['hero_id'] : 1
]);
$things = $things->fetchAll(PDO::FETCH_OBJ);
foreach ($things as $hero) {
    $rating = $db->prepare("SELECT * FROM rating WHERE heroId=:id");
    $rating->execute([
        'id' => $_POST['hero_id']
    ]);
    $rating = $rating->fetchAll(PDO::FETCH_OBJ);
    $totalRate = 0;
    foreach ($rating as $rate) {
        $totalRate += $rate->rating;
    }
    $yellowStars = 0;
    if($totalRate != 0) {
//    var_dump($rating, strftime("%d%m%G"));
//    $yellowStars = round($totalRate / 10 * 5);
        //var_dump(count($rating));
        $yellowStars = round($totalRate / count($rating));
        if ($yellowStars > 5)
            $yellowStars = round($yellowStars / 10 * 5);
    }
    $blackStars = 5 - $yellowStars;
    $stars = "";
    for($i = 1; $i <= $yellowStars; $i ++) {
        $stars .= "<i class=\"fa fa-star yellow\" aria-hidden=\"true\"></i>";
    }
    for($i = 0; $i < $blackStars; $i ++) {
        $stars .= "<i class=\"fa fa-star\" aria-hidden=\"true\"></i>";
    }
    echo "<div class='heroL'>
            <div class='top'>
                <div class=\"stars\">$stars</div>
                <h3 class='nicefont center'>$hero->HERO_NAME</h3>
                <img src='" . str_replace("\\", "/", $hero->HERO_IMAGE) . "' />
            </div>
            <div class='bottom'>
                <h1 class='nicefont'>Info</h1>
                <p>$hero->HERO_DESCRIPTION</p>
                
                <br />
                
                <h1 class='nicefont'>Powers</h1>
                <p>
                    <ul id='hero-power'>
                    ";
                    foreach (json_decode($hero->HERO_POWERS) as $POWER) {
                        echo "<li>$POWER</li>";
                    }
                    echo"
                    </ul>
                </p>
                
                <br />
                <h1 class='nicefont'>Rate this hero</h1>
                <form action='?team_id=$hero->TEAM_ID&hero_id=$hero->HERO_ID&rate=true' method='post' class='frmRate'>
                    <fieldset>
                        <div class=\"rate\">
                            <input type=\"radio\" id=\"rating10\" name=\"rating\" value=\"10\" /><label class=\"lblRating\" for=\"rating10\" title=\"5 stars\"></label>
                            <input type=\"radio\" id=\"rating9\" name=\"rating\" value=\"9\" /><label class=\"lblRating half\" for=\"rating9\" title=\"4 1/2 stars\"></label>
                            <input type=\"radio\" id=\"rating8\" name=\"rating\" value=\"8\" /><label class=\"lblRating\" for=\"rating8\" title=\"4 stars\"></label>
                            <input type=\"radio\" id=\"rating7\" name=\"rating\" value=\"7\" /><label class=\"lblRating half\" for=\"rating7\" title=\"3 1/2 stars\"></label>
                            <input type=\"radio\" id=\"rating6\" name=\"rating\" value=\"6\" /><label class=\"lblRating\" for=\"rating6\" title=\"3 stars\"></label>
                            <input type=\"radio\" id=\"rating5\" name=\"rating\" value=\"5\" /><label class=\"lblRating half\" for=\"rating5\" title=\"2 1/2 stars\"></label>
                            <input type=\"radio\" id=\"rating4\" name=\"rating\" value=\"4\" /><label class=\"lblRating\" for=\"rating4\" title=\"2 stars\"></label>
                            <input type=\"radio\" id=\"rating3\" name=\"rating\" value=\"3\" /><label class=\"lblRating half\" for=\"rating3\" title=\"1 1/2 stars\"></label>
                            <input type=\"radio\" id=\"rating2\" name=\"rating\" value=\"2\" /><label class=\"lblRating\" for=\"rating2\" title=\"1 star\"></label>
                            <input type=\"radio\" id=\"rating1\" name=\"rating\" value=\"1\" /><label class=\"lblRating half\" for=\"rating1\" title=\"1/2 star\"></label>
                            <input type=\"radio\" id=\"rating0\" name=\"rating\" value=\"0\" checked /><label class=\"lblRating\" for=\"rating0\" title=\"No star\"></label>
                        </div>
                        <div class=\"clearfix\"></div>
                        <br />
                        <div class=\"divSubmit\">
                        <textarea name='ratingReview' id='ratingReview' cols='40' rows='10' required></textarea>
                            <input type=\"submit\" name=\"submitRating\" class='btn' value=\"Rate Hero\"/>
                            <input type=\"hidden\" name=\"heroId\" value=\"$hero->HERO_ID\"/>
                        </div>
                    </fieldset>
                </form>
            </div>
          </div>";
}
die();