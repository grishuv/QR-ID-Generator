<?php include 'template.html'; ?>
<?php require_once 'admin-nav.php'; ?>
<?php
// Include your database connection file
include('db_connection.php');
session_start();

// Fetch admin data
$adminDataQuery = "SELECT * FROM users WHERE is_admin = 1";
$adminDataResult = $conn->query($adminDataQuery);
$adminData = $adminDataResult->fetch_assoc();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission and update the database
    $newName = $_POST['new_name'];
    $newEmail = $_POST['new_email'];
    $confirmEmail = $_POST['confirm_email'];

    if ($newEmail === $confirmEmail) {
        // Email confirmation successful
        $updateQuery = "UPDATE users SET name = '$newName', email = '$newEmail' WHERE is_admin = 1";
        
        if ($conn->query($updateQuery) === TRUE) {
            // Redirect to the admin profile page after successful update
            header("Location: admin-acc.php");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        $error_message = "Email confirmation does not match.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Admin Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <link rel="stylesheet" href="assets/css/admin-page.css" /> <!-- Create a new CSS file for styling if needed -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        #admin-profile-container {
            max-width: 400px; /* Adjust the width as needed */
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #191919;
            min-height: 200px;
        }


        h1 {
            margin-top: 20px;
            text-align: center;
            color: #fff;
        }

        #admin-profile-form {
            display: flex;
            flex-direction: column;
        }

        #admin-profile-form label {
            margin-bottom: 8px;
            font-weight: bold;
            color: #fff;
        }

        #admin-profile-form input {
            padding: 8px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px;
            background-color: #9290C3;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #535C91;
        }

        p {
            text-align: center;
            color: #fff;
        }
    </style> 
</head>
<body>
    <h1>Edit Admin Profile</h1>

    <div id="admin-profile-container">
            <form id="admin-profile-form">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="new_name">New Name:</label>
            <input type="text" id="new_name" name="new_name" value="<?php echo htmlspecialchars($adminData['name']); ?>" required>

            <label for="new_email">New Email:</label>
            <input type="text" id="new_email" name="new_email" value="<?php echo htmlspecialchars($adminData['email']); ?>" required>

            <label for="confirm_email">Confirm Email:</label>
            <input type="text" id="confirm_email" name="confirm_email" required>

            <!-- Add more fields as needed -->

            <?php if (isset($error_message)): ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
            <?php endif; ?>

            <button type="submit">Save Changes</button>
        </form>
    </div>
</body>
</html>
