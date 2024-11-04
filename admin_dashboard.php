<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: admin-login.php");
    exit();
}

// Read content from requests.txt
$requests = [];
$file = fopen('requests.txt', 'r');
if ($file) {
    while (($line = fgets($file)) !== false) {
        $requests[] = explode(' | ', trim($line));
    }
    fclose($file);
}

// Calculate total requests and done requests (assuming done requests are the last and marked as 'done')
$totalRequests = count($requests);
$totalDone = 0;
foreach ($requests as $request) {
    if (isset($request[7]) && $request[7] === 'done') {
        $totalDone++;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin_styles.css">
    <script src="admin_scripts.js" defer></script>
</head>
<body>
    <div class="dashboard-container">
        <h2>Content Requests</h2>
        <table class="dashboard-table">
            <thead>
                <tr>
                    <th>Serial No</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Details</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
    <?php foreach ($requests as $index => $request): ?>
        <tr>
            <td><?php echo $index + 1; ?></td>
            <td><?php echo $request[1]; ?></td>
            <td><?php echo explode(' ', $request[0])[0]; ?></td>
            <td><?php echo explode(' ', $request[0])[1]; ?></td>
            <td>
                <button class="details-btn" data-index="<?php echo $index; ?>">Details</button>
            </td>
            <td>
                <button class="tick-btn" data-index="<?php echo $index; ?>" onclick="markDone(<?php echo $index; ?>)">
                    ✔️
                </button>
                <button class="cross-btn" data-index="<?php echo $index; ?>" onclick="deleteRequest(<?php echo $index; ?>)">
                    ❌
                </button>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>
        </table>
    </div>

    <div id="details-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="modal-info"></div>
        </div>
    </div>

    <!-- Welcome Popup -->
    <div id="welcome-modal" class="modal">
        <div class="modal-content">
            <h3 style="font-size: 28px;">Welcome, Admin!</h3> <!-- Increased font size for the welcome message -->
            <p>Total Requests: <?php echo $totalRequests; ?></p>
            <p>Total Done Requests: <?php echo $totalDone; ?></p>
            <button id="close-welcome">Close</button>
        </div>
    </div>
</body>
</html>