<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

require_once '../db.php';

$response = [
    'status' => 'success',
    'data' => []
];

try {
    $stmt = $db->prepare("SELECT slug, title, content FROM pages ORDER BY title ASC");
    $stmt->execute();
    $pages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // We can calculate excerpt as well
    foreach ($pages as &$page) {
        $page['excerpt'] = mb_substr(strip_tags($page['content']), 0, 120) . '...';
        // We'll keep content because this API might be called for list and detail at the same time since there aren't many pages.
    }

    $response['data'] = $pages;
} catch (PDOException $e) {
    $response['status'] = 'error';
    $response['message'] = 'Database error: ' . $e->getMessage();
}

echo json_encode($response);
?>
