<?php 

require_once('db.php');

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_FILES['file_data'])){

    $uploadDir = 'images/';

    $file = $_FILES['file_data'];

    // Validate upload success
    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['status' => 'error', 'message' => 'Upload error code: ' . $file['error']]);
        exit;
    }

    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    if (!in_array($file['type'], $allowedTypes)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid file type']);
        exit;
    }

    $maxSize = 5 * 1024 * 1024;
    if ($file['size'] > $maxSize) {
        echo json_encode(['status' => 'error', 'message' => 'File too large']);
        exit;
    }

    $filename = basename($file['name']);
    $targetFile = $uploadDir . $filename;
    
    if (move_uploaded_file($file['tmp_name'], $targetFile)) {

        $stmt = $db_connect->prepare("INSERT INTO PHOTOS (filename) VALUES(?)");
        $stmt->bind_param('s',$filename);

        if($stmt->execute()){
            echo json_encode([
                'status' => 'success',
                'message' => 'File uploaded successfully',
                'filename' => $filename
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'File not uploaded',
                'filename' => $filename
            ]);
        }
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to move uploaded file']);
    }
} else{
    echo json_encode(['status' => 'error', 'message' => 'Please Upload File']);
    exit;
}