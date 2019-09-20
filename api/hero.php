<?php
require('../php_includes/db.php');

function json($data)
{
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    die(json_encode($data));
}

if (!isset($_GET['hero_id']) || empty($_GET['hero_id'])) {
    json([
        'error' => 'Missing \'hero_id\'',
    ]);
}

$heroId = $_GET['hero_id'];

$heroQuery = $db->prepare('SELECT * FROM heroes WHERE HERO_ID = :id');
$heroQuery->execute([
    'id' => $heroId,
]);
$hero = $heroQuery->fetch(PDO::FETCH_OBJ);

$hero->RATING = 0;
$hero->COMMENTS =  [];

$ratingQuery = $db->prepare('SELECT * FROM rating WHERE heroId = :id ORDER BY ratingId DESC');
$ratingQuery->execute([
    'id' => $heroId,
]);

$ratings = $ratingQuery->fetchAll(PDO::FETCH_OBJ);

$totalRate = 0;
$yellowStars = 0;

foreach ($ratings as $rating) {
    $totalRate += $rating->rating;
    $hero->COMMENTS[] = $rating->ratingReview;
}

if($totalRate != 0) {
    $yellowStars = round($totalRate / count($ratings));
    if ($yellowStars > 5) {
        $yellowStars = round($yellowStars / 10 * 5);
    }
}

//$blackStars = 5 - $yellowStars;

$hero->RATING = $yellowStars;

json($hero);
