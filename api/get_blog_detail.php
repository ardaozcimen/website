<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

require_once '../db.php';

$response = [
    'status' => 'success',
    'data' => null
];

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';

try {
    if ($id > 0) {
        $stmt = $db->prepare("SELECT * FROM blogs WHERE id = :id LIMIT 1");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    } else if (!empty($slug)) {
        $stmt = $db->prepare("SELECT * FROM blogs WHERE slug = :slug LIMIT 1");
        $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
    } else {
        $response['status'] = 'error';
        $response['message'] = 'No id or slug provided';
        echo json_encode($response);
        exit;
    }

    $stmt->execute();
    $blog = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($blog) {
        if ($blog['image_url']) {
            $blog['image_url'] = BASE_URL . $blog['image_url'];
        }
        $response['data'] = $blog;
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Blog not found';
    }
} catch (PDOException $e) {
    $response['status'] = 'error';
    $response['message'] = 'Database error: ' . $e->getMessage();
}

echo json_encode($response);
?>
