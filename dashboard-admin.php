<?php include 'template.html'; ?>
<?php require_once 'admin-nav.php'; ?>
<?php
include('db_connection.php');
session_start();

// Count the number of registered users
$userCountQuery = "SELECT COUNT(*) as user_count FROM users";
$userCountResult = $conn->query($userCountQuery);
$userCount = $userCountResult->fetch_assoc()['user_count'];

// Count the number of generated ID cards
$idCardCountQuery = "SELECT COUNT(*) as id_card_count FROM id_cards";
$idCardCountResult = $conn->query($idCardCountQuery);
$idCardCount = $idCardCountResult->fetch_assoc()['id_card_count'];

// Count the number of feedbacks
$feedbackCountQuery = "SELECT COUNT(*) as feedback_count FROM feedback";
$feedbackCountResult = $conn->query($feedbackCountQuery);
$feedbackCount = $feedbackCountResult->fetch_assoc()['feedback_count'];

// Fetch data for the chart
$chartQuery = "SELECT COUNT(id) as count, DAYOFWEEK(created_at) as day FROM id_cards GROUP BY day";
$chartResult = $conn->query($chartQuery);
$dataPoints = [];
while ($row = $chartResult->fetch_assoc()) {
    $dataPoints[] = [
        'x' => $row['day'],  // Assuming the day is an integer (1 to 7)
        'y' => $row['count']
    ];
}

// Fetch the top 4 latest feedbacks based on the highest id values
$topFeedbacksQuery = "SELECT * FROM feedback ORDER BY id DESC LIMIT 4";
$topFeedbacksResult = $conn->query($topFeedbacksQuery);
$topFeedbacks = $topFeedbacksResult->fetch_all(MYSQLI_ASSOC);
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <link rel="stylesheet" href="assets/css/dashboard-admin.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>SmartIDCoder</h1>
<div class="admin-container">
    <div class="count-container">
        <h2>Total Users</h2>
        <p><i class="fas fa-users"></i> <?php echo $userCount; ?></p>
    </div>

    <div class="count-container">
        <h2>Total ID Generated</h2>
        <p><i class="fas fa-id-card"></i> <?php echo $idCardCount; ?></p>
    </div>

    <div class="count-container">
        <h2>Total Feedbacks</h2>
        <p><i class="fas fa-comment"></i> <?php echo $feedbackCount; ?></p>
    </div>
</div>

<div class="chart-feedback-container">
    <!-- Chart container -->
    <div class="chart-container">
        <canvas id="myChart"></canvas>
    </div>

<!-- Feedback container in HTML -->
<div class="feedback-container">
    <h2>Latest Feedbacks</h2>
    <?php if ($topFeedbacks): ?>
        <ul>
            <?php foreach ($topFeedbacks as $feedback): ?>
                <li><?php echo htmlspecialchars($feedback['feedback']); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No feedbacks available.</p>
    <?php endif; ?>
</div>

<script>
    // JavaScript code for chart
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',  // Use bar chart for days
        data: {
            labels: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
            datasets: [{
                label: 'ID-Card Generations',
                data: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>,
                backgroundColor: '#535C91',
                borderColor: '#9290C3',
                borderWidth: 1
            }]
        },
        options: {
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Day of the Week',
                    color: 'white' // Set the title color to white
                },
                ticks: {
                    color: 'white' // Set the tick color to white
                },
                grid: {
                    color: 'rgba(255, 255, 255, 0.1)'
                }
            },
            y: {
                title: {
                    display: true,
                    text: 'Number of Card Generations',
                    color: 'white' // Set the title color to white
                },
                ticks: {
                    color: 'white' // Set the tick color to white
                },
                grid: {
                    color: 'rgba(255, 255, 255, 0.1)'
                }
            }
        }
    }
});
</script>
</div>
</body>
</html>
