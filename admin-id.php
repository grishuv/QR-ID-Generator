<?php include 'template.html'; ?>
<?php require_once 'admin-nav.php'; ?>
<?php
require_once 'db_connection.php'; // Make sure this file contains the database connection details
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="assets/css/admin-id.css" />
</head>
<body>
    <h1>ID-card generated info - Admin Panel</h1>
    <div class="container">
<?php
require_once 'db_connection.php'; // Make sure this file contains the database connection details

// Fetch all ID card data from the database
$query = "SELECT * FROM id_cards";
$result = $conn->query($query);

// Check if there are any results
if ($result->num_rows > 0) {
    echo '<table border="1">';
    echo '<tr><th>ID</th><th>Name</th><th>DOB</th><th>Gender</th><th>Address</th><th>Branch</th><th>Year</th><th>Blood Group</th><th>College Name</th><th>College Address</th><th>Enrollment No</th><th>Phone</th><th>QR Code</th><th>Photo</th></tr>';
    
    // Loop through the results and display each row
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . $row['name'] . '</td>';
        echo '<td>' . $row['dob'] . '</td>';
        echo '<td>' . $row['gender'] . '</td>';
        echo '<td>' . $row['address'] . '</td>';
        echo '<td>' . $row['branch'] . '</td>';
        echo '<td>' . $row['year'] . '</td>';
        echo '<td>' . $row['blood_group'] . '</td>';
        echo '<td>' . $row['college_name'] . '</td>';
        echo '<td>' . $row['college_address'] . '</td>';
        echo '<td>' . $row['enrollment_no'] . '</td>';
        echo '<td>' . $row['phone'] . '</td>';
        echo '<td><img src="data:image/png;base64,' . $row['qr_code'] . '" alt="QR Code" style="width:50px;height:50px;"></td>';
        echo '<td><img src="data:image;base64,' . $row['photo'] . '" alt="Photo" style="width:50px;height:50px;"></td>';
        echo '</tr>';
    }

    echo '</table>';
} else {
    echo 'No records found';
}

// Close the database connection
$conn->close();
?>
    </div>
</body>
</html>