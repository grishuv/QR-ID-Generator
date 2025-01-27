<?php
// Include your database connection file
include('db_connection.php');

// Fetch all user data from the database
$fetch_users_query = "SELECT * FROM users";
$users_result = $conn->query($fetch_users_query);

// Check for any errors in the query
if (!$users_result) {
    die("Error: " . $conn->error);
}
?>
<?php include 'template.html'; ?>
<?php require_once 'admin-nav.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="assets/css/acc.css" />
</head>
<body>

    <h1>User Accounts - Admin Panel</h1>
    <div class="container">
    <table border="1">
        <tr>
            <th>User ID</th>
            <th>Name</th>
            <th>Email</th>
            <!-- Add more columns as needed -->
        </tr>

        <?php
        // Loop through each row in the result set and display user information
        while ($user_data = $users_result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $user_data['id'] . "</td>";
            echo "<td>" . $user_data['name'] . "</td>";
            echo "<td>" . $user_data['email'] . "</td>";
            // Add more columns as needed
            echo "</tr>";
        }
        ?>
    </table>
    </div>

</body>
</html>
