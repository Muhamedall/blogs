<?php
require_once "../app/core/connection.php";

$conn = get_connection();

$todayPostsCount = get_today_posts_count($conn);
$todayVisitorsCount = get_today_visitors_count($conn);
$newSubscribersCount = get_new_subscribers_count($conn);

$response = [
    'todayPostsCount' => $todayPostsCount,
    'todayVisitorsCount' => $todayVisitorsCount,
    'newSubscribersCount' => $newSubscribersCount
];

header('Content-Type: application/json');
echo json_encode($response);
?>
