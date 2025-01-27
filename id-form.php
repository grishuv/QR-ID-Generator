<!-- id-form.php -->
<?php
require_once 'phpqrcode-master\qrlib.php';
require_once 'db_connection.php'; 

session_start();

// Check if the form is submitted
if (isset($_POST['submit'])) {
    $fields = ['name', 'dob', 'gender', 'address', 'branch', 'year', 'blood_group', 'college_name', 'college_address', 'enrollment_no', 'phone'];

    // Generate unique ID
    $id = uniqid();
    $_SESSION['id'] = $id;

    foreach ($fields as $field) {
        $_SESSION[$field] = $_POST[$field];
    }

    // Check if a file was uploaded for photo
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $photoFileName = $_FILES['photo']['name'];
        move_uploaded_file($_FILES['photo']['tmp_name'], $photoFileName);
    } else {
        $photoFileName = "default_photo.jpg"; // Provide a default photo if none is uploaded
    }

    // Read the photo file content
    $photoImageData = base64_encode(file_get_contents($photoFileName));

    $_SESSION['photo'] = $photoFileName;

    // Check if a file was uploaded for signature
    if (isset($_FILES['signature']) && $_FILES['signature']['error'] === UPLOAD_ERR_OK) {
        $signatureFileName = $_FILES['signature']['name'];
        move_uploaded_file($_FILES['signature']['tmp_name'], $signatureFileName);
    } else {
        $signatureFileName = "default_signature.jpg"; // Provide a default signature if none is uploaded
    }

    // Read the signature file content
    $signatureImageData = base64_encode(file_get_contents($signatureFileName));

    $_SESSION['signature'] = $signatureFileName;

    // Save QR code image to the database
    // Generate QR code image based on the current session data
    $qrCodeContent = json_encode($_SESSION);
    QRcode::png($qrCodeContent, 'qrcode.png');
    $qrCodeImageData = base64_encode(file_get_contents("qrcode.png"));


    $stmt = $conn->prepare("INSERT INTO id_cards (id, photo, name, dob, gender, address, branch, year, blood_group, college_name, college_address, enrollment_no, phone, qr_code, signature) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind parameters
    $stmt->bind_param("sssssssssssssss", $id, $photoImageData, $_SESSION['name'], $_SESSION['dob'], $_SESSION['gender'], $_SESSION['address'], $_SESSION['branch'], $_SESSION['year'], $_SESSION['blood_group'], $_SESSION['college_name'], $_SESSION['college_address'], $_SESSION['enrollment_no'], $_SESSION['phone'], $qrCodeImageData, $signatureImageData);

    // Execute the statement
    $stmt->execute();

    // Close statement
    $stmt->close();
}
?>
<?php include 'template.html'; ?>
<?php require_once 'nav-bar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Card Generator</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <link rel="stylesheet" href="assets\css\id-form.css">
</head>
<body>
<div class="header-content">
    <div class="text-content">
        <h1>SmartIDCoder</h1>
        <p>Generate your ID card with ease!</p><br>
        <p>Welcome to <b>SmartIDCoder</b>, your one-stop solution for generating personalized ID cards effortlessly!
        With our user-friendly interface, you can input your details seamlessly and create custom ID cards
        tailored to your needs. Simply fill in the required information, upload a photo, and let SmartIDCoder
        handle the rest. Our innovative system ensures the generation of professional-looking ID cards with
        a unique QR code for quick identification. Get started now and experience the convenience of SmartIDCoder
         – the smart choice for ID card creation!</p><br<<br><br>

         <p>Join <b>SmartIDCoder</b>. You can get a fantastic unique ID card in minutes.And you even can add a QR code
             or barcode to make your ID card memorable and carry more content at the same time.</p>

    </div>
    <img src="assets\images\i.png" alt="Image Description">
</div>
<div class="container">
    <div class="form-container">
        <h1>SmartIDCoder</h1>
        <form action="#result" method="post" enctype="multipart/form-data">
            <div class="input-columns">
                <div class="input-column">
                    <?php
                    $fields = ['name', 'dob', 'gender', 'address', 'branch', 'year'];
                    foreach ($fields as $field): ?>
                        <div class="input-container">
                            <label for="<?php echo $field; ?>"><?php echo ucfirst($field); ?>:</label>
                            <?php if ($field === 'gender'): ?>
                                <select id="<?php echo $field; ?>" name="<?php echo $field; ?>" required>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            <?php else: ?>
                                <input type="<?php echo ($field === 'dob') ? 'date' : 'text'; ?>" id="<?php echo $field; ?>" name="<?php echo $field; ?>" placeholder="<?php echo ucfirst($field); ?>" required>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                    <div class="sign-container">
                        <label for="signature">Signature:</label>
    <input type="file" id="signature" name="signature" accept="image/*">
                    </div>
                </div>
                <div class="input-column">
                    <?php
                    $fields = ['blood_group', 'college_name', 'college_address', 'enrollment_no', 'phone'];
                    foreach ($fields as $field): ?>
                        <div class="input-container">
                            <label for="<?php echo $field; ?>"><?php echo ucfirst($field); ?>:</label>
                            <input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" placeholder="<?php echo ucfirst($field); ?>" required>
                        </div>
                    <?php endforeach; ?>
                    <div class="input-container">
                        <label for="photo">Photo:</label>
                        <input type="file" id="photo" name="photo" accept="image/*">
                    </div>
                </div>
            </div>
            <input type="submit" name="submit" value="Generate ID Card">
            <?php if (isset($_SESSION['id'])): ?>
                <button id="downloadFrontButton" type="button">Download Front Side</button>
                <button id="downloadBackButton" type="button">Download Back Side</button>
            <?php endif; ?>
        </form>
    </div>
    <div class="id-card-container" id="result">
        <?php if (isset($_SESSION['id'])): ?>
            <?php include 'id_card.php'; ?>
        <?php endif; ?>
    </div>
</div>


<!-- Inside the existing HTML file, before the closing </body> tag -->
<div class="feedback-container">
    <h2>SmartIDCoder-Feedback</h2>
    <h3>"Your feedback is our compass. Let us know how we're doing and how we can make things even better!"</h3>
    <form action="process_feedback.php" method="post">
        <label for="feedback">Your Feedback:</label><br>
        <div class="input-group">
        <input type="text" id="feedback" name="feedback" required>
            <input type="submit" name="submit_feedback" value="Submit Feedback">
        </div>
    </form>
        <p>"At SmartIDCoder, we're on a mission to provide you with the best ID card generation experience possible. Your opinion is incredibly valuable<br>
            to us as we strive for excellence in our service. Whether you've just created a unique ID card or have suggestions for improvement, we want<br>
            to hear from you! Your feedback fuels our commitment to innovation and ensures that SmartIDCoder continues to meet your needs seamlessly.<br>
            Join us on this journey of continuous improvement, and let your voice shape the future of SmartIDCoder.Thank you for being a part of our community<br>
            and we look forward to hearing your thoughts!"</p>
</div>



    <!-- Update the script section in your HTML -->
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const downloadFrontButton = document.getElementById('downloadFrontButton');
            const downloadBackButton = document.getElementById('downloadBackButton');

            function downloadCard(side) {
                const cardSideContainer = document.querySelector(`.${side}`);
                html2canvas(cardSideContainer).then(function (canvas) {
                    const imageData = canvas.toDataURL('image/png');
                    const downloadLink = document.createElement('a');
                    downloadLink.href = imageData;
                    downloadLink.download = `id_card_${side}.png`;
                    downloadLink.click();
                });
            }

            if (downloadFrontButton) {
                downloadFrontButton.addEventListener('click', function () {
                    downloadCard('front');
                });
            }

            if (downloadBackButton) {
                downloadBackButton.addEventListener('click', function () {
                    downloadCard('back');
                });
            }
        });
    </script>
</body>
</html>
