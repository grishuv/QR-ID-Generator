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

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
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
    <h1>Admin Profile</h1>
    <div id="admin-profile-container">
        <?php if ($adminData): ?>
            <form id="admin-profile-form">
            <form>
                <label for="id">ID:</label>
                <input type="text" id="id" name="id" value="<?php echo $adminData['id']; ?>" readonly>

                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($adminData['name']); ?>" readonly>

                <label for="email">Email:</label>
                <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($adminData['email']); ?>" readonly>

                <!-- Add more fields as needed -->

                <button type="button" onclick="editProfile()">Edit Profile</button>
            </form>
        <?php else: ?>
            <p>No admin data available.</p>
        <?php endif; ?>
    </div>
        </div>
    <script>
        function editProfile() {
            // Redirect to the edit profile page or implement your edit logic here
            window.location.href = 'admin-acc-edit.php';
        }
    </script>
</body>
</html>
