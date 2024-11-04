<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Set timezone to Dhaka (GMT+6)
    date_default_timezone_set('Asia/Dhaka');

    // Collect and sanitize input
    $type = htmlspecialchars($_POST['type']);
    $movie_name = htmlspecialchars($_POST['movie_name']);
    $year = htmlspecialchars($_POST['year']);
    $language = htmlspecialchars($_POST['language']);
    $quality = htmlspecialchars($_POST['quality']);
    $user_ip = $_SERVER['REMOTE_ADDR']; // Get user IP address

    // Create a timestamp in 'day-month-year' and 12-hour format
    $timestamp = date("d-m-Y h:i:s A");

    // Open the file for appending
    $file = fopen('requests.txt', 'a');
    if ($file) {
        // Write the data to the file in the correct order
        fwrite($file, "$timestamp | $type | $movie_name | $year | $language | $quality | $user_ip\n");
        fclose($file);
        
        // Redirect to success.html after submission
        header("Location: success.html");
        exit();
    } else {
        echo "Error opening the file.";
    }
}
?>