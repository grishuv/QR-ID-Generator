<?php include 'template.html'; ?>
<?php require_once 'admin-nav.php'; ?>
<?php
require_once 'db_connection.php';

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
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
}

h1 {
    text-align: left;
    margin-top: 20px;
    margin-left: 60px;
}

.chart-container {
    width: 90%;
    margin: 40px 40px 40px 40px;
    background-color: black;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    border-radius: 20px;
    padding: 20px;
}
    </style>
</head>
<body>
    <h1>Card Generation Statistics</h1>

    <div class="chart-feedback-container">
    <!-- Chart container -->
    <div class="chart-container">
        <canvas id="myChart"></canvas>
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
