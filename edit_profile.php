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

// Define variables to store error messages
$error_message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_name = $_POST["new_name"];
    $new_email = $_POST["new_email"];
    $current_password = $_POST["current_password"];
    $new_password = $_POST["new_password"];
    $confirm_new_password = $_POST["confirm_new_password"];

    // Perform any necessary validation

    // Check if the current password matches the stored password
    if ($current_password != $user_data['password']) {
        $error_message = "Current password is incorrect.";
    } elseif ($new_password != $confirm_new_password) {
        // Check if the new password and confirm password match
        $error_message = "New password and confirm password do not match.";
    } else {
        // Update the user data in the database, including password change
        $update_query = "UPDATE users SET name='$new_name', email='$new_email', password='$new_password' WHERE id='$user_id'";

        if ($conn->query($update_query) === TRUE) {
            // Redirect to the dashboard after successful update
            header("Location: dashboard.php");
            exit();
        } else {
            // Handle the query error if needed
            $error_message = "Error updating profile: " . $conn->error;
        }
    }
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
    <title>Edit Profile</title>
    <link rel="stylesheet" href="assets\css\edit_profile.css">
</head>
<body>
    <header>
        <h1>Edit Your Profile</h1>
    </header>

    <div class="container">
        <section>
            <form method="POST" action="">
                <label for="new_name">New Name:</label>
                <input type="text" id="new_name" name="new_name" value="<?php echo $user_data['name']; ?>" required>

                <label for="new_email">New Email:</label>
                <input type="email" id="new_email" name="new_email" value="<?php echo $user_data['email']; ?>" required>

                <!-- Add these fields inside the existing form -->
<!-- Add these fields inside the existing form -->
<label for="current_password">Current Password:</label>
<input type="password" id="current_password" name="current_password" autocomplete="new-password" required>

<label for="new_password">New Password:</label>
<input type="password" id="new_password" name="new_password" minlength="10" autocomplete="new-password" required>

<label for="confirm_new_password">Confirm New Password:</label>
<input type="password" id="confirm_new_password" name="confirm_new_password" minlength="10" autocomplete="new-password" required>


<div class="buttons">
    <button type="submit" class="custom-button">Save Changes</button>
    <button type="button" class="custom-button" onclick="window.location.href='profile.php'">Cancel</button>
</div>
            </form>
            <?php if ($error_message): ?>
                <div class="error-message">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
        </section>
    </div>
</body>
</html>
