<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

require_once '../db.php';

$response = [
    'status' => 'success',
    'data' => []
];

try {
    $stmt = $db->prepare("SELECT id, title, image_url, created_at, slug, content FROM blogs ORDER BY created_at DESC");
    $stmt->execute();
    $blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($blogs as &$blog) {
        if ($blog['image_url']) {
            $blog['image_url'] = BASE_URL . $blog['image_url'];
        }
        // Excerpt calculation
        $blog['excerpt'] = mb_substr(strip_tags($blog['content']), 0, 100) . '...';
        unset($blog['content']); // Don't send full content in the list API
    }
    
    $response['data'] = $blogs;
} catch (PDOException $e) {
    $response['status'] = 'error';
    $response['message'] = 'Database error: ' . $e->getMessage();
}

echo json_encode($response);
?>
