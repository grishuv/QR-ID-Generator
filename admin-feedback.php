<?php include 'template.html'; ?>
<?php require_once 'admin-nav.php'; ?>
<?php
require_once 'db_connection.php';

// Fetch all feedback data from the database
$query = "SELECT * FROM feedback";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Feedback</title>
    <link rel="stylesheet" href="assets/css/admin-feedback.css" />
</head>
<body>
    <h1>Feedbacks</h1>
<div class="container">
        <?php
    // Check if there are any feedbacks
    if ($result->num_rows > 0) {
        echo '<table>';
        echo '<tr><th>ID</th><th>Feedback</th></tr>';

        // Loop through the results and display each row
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . $row['feedback'] . '</td>';
            echo '</tr>';
        }

        echo '</table>';
    } else {
        echo '<p>No feedbacks found.</p>';
    }

    // Close the database connection
    $conn->close();
    ?>
    </div>
</body>
</html>
