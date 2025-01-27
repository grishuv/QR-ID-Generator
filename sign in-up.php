<?php
// Include your database connection file
include('db_connection.php');

session_start();

// Define variables to store error messages
$error_message = "";
$password_error = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check which form is submitted (sign-up or sign-in)
    if (isset($_POST["signup"])) {
        // Handle sign-up form
        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];

        // Perform any necessary validation

        // Check if the passwords match
        if ($password !== $confirm_password) {
            $error_message = "Passwords do not match. Please enter matching passwords.";
        } else {
            // Check if the email or name already exists in the database
            $check_existing_query = "SELECT * FROM users WHERE email='$email' OR name='$name'";
            $result = $conn->query($check_existing_query);

            if ($result->num_rows > 0) {
                // User with the same email or name already exists
                $error_message = "User with the same email or name already exists. Please choose a different email or name.";
            } else {
                // Insert data into the database
                $query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";

                // Use the established database connection for the query
                if ($conn->query($query) === TRUE) {
                    // Redirect to sign-in form
                    header("Location: sign in-up.php");
                    exit();
                } else {
                    // Handle the query error if needed
                    $error_message = "Error: " . $conn->error;
                }
            }
        }
    } elseif (isset($_POST["signin"])) {
// Handle sign-in form
$email = $_POST["email"];
$password = $_POST["password"];

// Perform any necessary validation

// Check if the user exists in the database
$check_user_query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
$result = $conn->query($check_user_query);

if ($result->num_rows > 0) {
    $user_data = $result->fetch_assoc();

    // Check if the user is an admin
    if ($user_data['is_admin'] == 1) {
        // User is an admin, redirect to admin dashboard
        header("Location: dashboard-admin.php");
        exit();
    } else {
        // User is not an admin, redirect to regular user page (id-form.php)
        $_SESSION['user_id'] = $user_data['id'];
        header("Location: id-form.php");
        exit();
    }
} else {
    // User does not exist or credentials are incorrect
    $error_message = "Invalid email or password";
}
    }
}
?>

<?php include 'template.html'; ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign in & Sign up Form</title>
    <link rel="stylesheet" href="assets\css\sign in-up.css" />
  </head>
  <body>
    <main>
      <div class="box">
        <div class="inner-box">
          <div class="forms-wrap">
            <form action="" autocomplete="off" class="sign-in-form" method="POST">
              <div class="logo">
                <img src="assets\images\qr-code-scan.png" alt="SmartIDCoder" />
                <h4>SmartIDCoder</h4>
              </div>

              <div class="heading">
                <h2>Welcome Back</h2>
                <h6>Not registred yet?</h6>
                <a href="#" class="toggle">Sign up</a>
              </div>

              <div class="actual-form">
               <div class="input-wrap">
                <input
                    type="email"
                    name="email"
                    class="input-field"
                    autocomplete="off"
                    required
                  />
                <label>Email</label>
                </div>

                <div class="input-wrap">
                  <input
                    type="password"
                    name="password"
                    minlength="4"
                    class="input-field"
                    autocomplete="off"
                    required
                  />
                  <label>Password</label>
                </div>
                <input type="hidden" name="signin" value="1" />
                <input type="submit" value="Sign In" class="sign-btn" />

                <p class="text">
                  Forgotten your password or you login datails?
                  <a href="#">Get help</a> signing in
                </p>
              </div>
            </form>

            <form action="" autocomplete="off" class="sign-up-form" method="POST" id="signup-form">
              <div class="logo">
                <img src="assets\images\qr-code-scan.png" alt="SmartIDCoder" />
                <h4>SmartIDCoder</h4>
              </div>

              <div class="heading">
                <h2>Get Started</h2>
                <h6>Already have an account?</h6>
                <a href="#" class="toggle">Sign in</a>
              </div>

              <div class="actual-form">
                <div class="input-wrap">
                  <input
                    type="text"
                    name="name"
                    minlength="4"
                    class="input-field"
                    autocomplete="off"
                    required
                  />
                  <label>Name</label>
                </div>

                <div class="input-wrap">
                  <input
                    type="email"
                    name="email"
                    class="input-field"
                    autocomplete="off"
                    required
                  />
                  <label>Email</label>
                </div>

                <div class="input-wrap">
    <input
        type="password"
        name="confirm_password"
        minlength="10"
        class="input-field"
        autocomplete="off"
        required
    />
    <label>Confirm Password</label>
</div>

                <div class="input-wrap">
                  <input
                    type="password"
                    name="password"
                    minlength="10"
                    class="input-field"
                    autocomplete="off"
                    required
                  />
                  <label>Password</label>
                </div>
                <input type="hidden" name="signup" value="1" />
                <input type="submit" value="Sign Up" class="sign-btn" />

                <p class="text">
                  By signing up, I agree to the
                  <a href="#">Terms of Services</a> and
                  <a href="#">Privacy Policy</a>
                </p>
              </div>
            </form>
          </div>

          <div class="carousel">
            <div class="images-wrapper">
              <img src="assets\images\1.png" class="image img-1 show" alt="" />
              <img src="assets\images\2.png" class="image img-2" alt="" />
              <img src="assets\images\3.png" class="image img-3" alt="" />
            </div>

            <div class="text-slider">
              <div class="text-wrap">
                <div class="text-group">
                  <h2>Create your own SmartID</h2>
                  <h2>Customize as you like</h2>
                  <h2>Invite students to New Genertion Features</h2>
                </div>
              </div>

              <div class="bullets">
                <span class="active" data-value="1"></span>
                <span data-value="2"></span>
                <span data-value="3"></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>


    <div class="overlay" id="overlay"></div>
    <?php if ($error_message): ?>
        <div class="error-popup" id="errorPopup">
            <p><?php echo $error_message; ?></p>
            <button onclick="closeErrorPopup()">Close</button>
        </div>
        <script>
            function closeErrorPopup() {
                document.getElementById('overlay').style.display = 'none';
                document.getElementById('errorPopup').style.display = 'none';
            }

            // Display the overlay and error popup on page load
            window.onload = function() {
                document.getElementById('overlay').style.display = 'block';
                document.getElementById('errorPopup').style.display = 'block';
            }
        </script>
    <?php endif; ?>

    <?php if ($password_error): ?>
        <div class="error-popup" id="passwordErrorPopup">
            <p><?php echo $password_error; ?></p>
            <button onclick="closePasswordErrorPopup()">Close</button>
        </div>
        <script>
            function closePasswordErrorPopup() {
                document.getElementById('overlay').style.display = 'none';
                document.getElementById('passwordErrorPopup').style.display = 'none';
            }

            // Display the overlay and password error popup on page load
            window.onload = function() {
                document.getElementById('overlay').style.display = 'block';
                document.getElementById('passwordErrorPopup').style.display = 'block';
            }
        </script>
    <?php endif; ?>

    <script src="assets/js/app.js"></script>
  </body>
</html>