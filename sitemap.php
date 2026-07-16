<?php
require_once 'db.php';

// Set the content type to XML
header("Content-Type: application/xml; charset=utf-8");

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

// Function to generate a url node
function addUrl($loc, $lastmod = '', $changefreq = 'weekly', $priority = '0.8') {
    global $isLocal;
    
    // For local env testing, BASE_URL is /konyatupbebek/, we want full absolute URLs in sitemap
    $domain = "https://www.konyatupbebek.com";
    if ($isLocal) {
        $domain = "http://localhost"; 
    }
    
    $fullUrl = $domain . BASE_URL . ltrim($loc, '/');
    
    echo "  <url>\n";
    echo "    <loc>" . htmlspecialchars($fullUrl) . "</loc>\n";
    if (!empty($lastmod)) {
        echo "    <lastmod>" . $lastmod . "</lastmod>\n";
    }
    echo "    <changefreq>" . $changefreq . "</changefreq>\n";
    echo "    <priority>" . $priority . "</priority>\n";
    echo "  </url>\n";
}

$today = date('Y-m-d');

// Static Pages
addUrl('', $today, 'daily', '1.0'); // index
addUrl('hakkimizda', $today, 'monthly', '0.8');
addUrl('blog', $today, 'daily', '0.9');
addUrl('bebeklerimiz', $today, 'monthly', '0.8');
addUrl('sss', $today, 'monthly', '0.8');
addUrl('iletisim', $today, 'monthly', '0.9');

// Detay Pages (Treatments / Causes) - Dynamically fetched from database
try {
    $stmt = $db->query("SELECT slug FROM pages");
    $pages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($pages as $page) {
        addUrl('detay/' . $page['slug'], $today, 'monthly', '0.8');
    }
} catch (Exception $e) {
    // Graceful fallback
}

// Dynamic Blog Pages
try {
    $stmt = $db->query("SELECT slug, updated_at, created_at FROM blogs ORDER BY id DESC");
    $blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($blogs as $blog) {
        $lastmod = !empty($blog['updated_at']) ? date('Y-m-d', strtotime($blog['updated_at'])) : date('Y-m-d', strtotime($blog['created_at']));
        addUrl('blog/' . $blog['slug'], $lastmod, 'weekly', '0.9');
    }
} catch (Exception $e) {
    // If table doesn't exist or error occurs, skip gracefully
}

echo '</urlset>';
?>
