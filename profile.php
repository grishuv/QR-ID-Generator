<?php
// Include your database connection file
include('db_connection.php');

// Start the session
session_start();

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: sign in-up.php");
    exit();
}

// Fetch user data from the database
$user_id = $_SESSION['user_id'];
$user_query = "SELECT * FROM users WHERE id='$user_id'";
$user_result = $conn->query($user_query);

if ($user_result->num_rows > 0) {
    $user_data = $user_result->fetch_assoc();
} else {
    // Handle case where user data is not found
    echo "User data not found.";
    exit();
}
?>
<?php include 'template.html'; ?>
<?php require_once 'nav-bar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="assets\css\profile.css">
</head>
<body>
    <header>
        <h1>Welcome to Your SmartIDCoder, <?php echo $user_data['name']; ?>!</h1>
    </header>
    
    <div class="container">
        <section>
            <h2>User Information</h2>
            <form>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $user_data['name']; ?>" readonly>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $user_data['email']; ?>" readonly>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" value="<?php echo $user_data['password']; ?>" readonly>

                <!-- Add more fields as needed -->

                <div class="buttons">
    <a href="edit_profile.php" class="custom-link">Edit Profile</a>
    <a href="logout.php" class="custom-link">Logout</a>
</div>
            </form>
        </section>
    </div>

    <!-- Add more sections or content as needed -->

    <!-- Add your footer content here -->

    <script src="app.js"></script>
</body>
</html>
