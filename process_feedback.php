<?php
require_once 'db_connection.php';

if (isset($_POST['submit_feedback'])) {
    // Get feedback from the form
    $feedback = $_POST['feedback'];

    // Insert feedback into the database
    $stmt = $conn->prepare("INSERT INTO feedback (feedback) VALUES (?)");
    $stmt->bind_param("s", $feedback);
    $stmt->execute();
    $stmt->close();
}

// Redirect back to the main page after processing feedback
header("Location: id-form.php");
?>
