<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

if (isset($_GET['index']) && isset($_GET['status'])) {
    $index = (int)$_GET['index'];
    $status = $_GET['status'];

    // Read all requests
    $requests = [];
    $file = fopen('requests.txt', 'r');
    if ($file) {
        while (($line = fgets($file)) !== false) {
            $requests[] = trim($line);
        }
        fclose($file);
    }

    // Update the specified request
    if (isset($requests[$index])) {
        // Assuming the last part of the line holds the status
        $parts = explode(' | ', $requests[$index]);
        if (count($parts) >= 8) { // Adjust according to the number of parts
            $parts[7] = 'done'; // Set the status to done
        }
        $requests[$index] = implode(' | ', $parts);
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