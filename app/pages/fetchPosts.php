<?php
require_once "../app/core/connection.php";

$posts_per_page = 6; // Number of posts per page
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $posts_per_page;

$conn = get_connection();
$stmt = $conn->prepare("SELECT * FROM posts ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
$stmt->bindParam(':limit', $posts_per_page, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch total number of posts for pagination
$total_posts_stmt = $conn->query("SELECT COUNT(*) FROM posts");
$total_posts = $total_posts_stmt->fetchColumn();
$total_pages = ceil($total_posts / $posts_per_page);

// Prepare the response data
$response = [
    'posts' => $posts,
    'pagination' => [
        'current_page' => $current_page,
        'total_pages' => $total_pages,
    ]
];

// Set response headers to indicate JSON content
header('Content-Type: application/json');

// Output the response data as JSON
echo json_encode($response);
?>
