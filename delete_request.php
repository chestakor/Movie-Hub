<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

if (isset($_GET['index'])) {
    $index = (int)$_GET['index'];

    // Read all requests
    $requests = [];
    $file = fopen('requests.txt', 'r');
    if ($file) {
        while (($line = fgets($file)) !== false) {
            $requests[] = trim($line);
        }
        fclose($file);
    }

    // Remove the specified request
    if (isset($requests[$index])) {
        unset($requests[$index]); // Remove the entry
    }

    // Write back to the file
    $file = fopen('requests.txt', 'w');
    if ($file) {
        foreach ($requests as $request) {
            fwrite($file, $request . "\n");
        }
        fclose($file);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error writing to the file.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>