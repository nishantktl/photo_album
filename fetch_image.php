<?php
require_once('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 6;
    $offset = ($page - 1) * $limit;

    $totalQuery = $db_connect->query("SELECT COUNT(*) as total FROM photos");
    $totalRow = $totalQuery->fetch_assoc();
    $totalImages = (int)$totalRow['total'];
    $totalPages = ceil($totalImages / $limit);

    $stmt = $db_connect->prepare("SELECT filename FROM photos ORDER BY id DESC LIMIT ?, ?");
    $stmt->bind_param('ii', $offset, $limit);
    $stmt->execute();
    $result = $stmt->get_result();

    $images = [];
    while ($row = $result->fetch_assoc()) {
        $images[] = [
            'filename' => $row['filename']
        ];
    }

    $stmt->close();

    echo json_encode([
        'status' => 'success',
        'page' => $page,
        'totalPages' => $totalPages,
        'images' => $images
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method'
    ]);
}
