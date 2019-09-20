<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: *');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    die();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die();
}

if (!isset($_POST['hero_id'], $_POST['rating'], $_POST['ratingReview'])) {
    die();
}

require('../php_includes/db.php');

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
    'hero_id' => $_POST['hero_id'],
    'rating' => $_POST['rating'],
    'rating_date' => strftime('%d%m%G'),
    'ratingReview' => $_POST['ratingReview']
]);

header('Content-Type: application/json');
die(json_encode([
    'success' => true,
]));
