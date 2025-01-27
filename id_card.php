<?php
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
}

$id = $_SESSION['id'];
$photoFileName = $_SESSION['photo'];
$signatureFileName = $_SESSION['signature'];
$fields = ['name', 'dob', 'gender', 'address', 'branch', 'year', 'blood_group', 'college_name', 'enrollment_no', 'phone', 'signature']; // Add 'signature' to the fields array
?>

<div class="id-card">
    <div class="front">
        <h1><?php echo $_SESSION['college_name']; ?></h1>
        <p class="college-address"><?php echo $_SESSION['college_address']; ?></p>
        <img src="<?php echo $_SESSION['photo']; ?>" alt="Photo" class="photo">
        <div class="info-box">
            <?php foreach ($fields as $field): ?>
                <?php if ($field !== 'college_name' && $field !== 'college_address' && $field !== 'name'): ?>
                    <?php if ($field === 'signature'): ?>
                        <div class="signature-label">
                            <span class="label"><?php echo ucfirst($field); ?>:</span>
                        </div>
                    <?php else: ?>
                        <div class="info">
                            <span class="label"><?php echo ucfirst($field); ?>:</span>
                            <span class="value"><?php echo $_SESSION[$field]; ?></span>
                        </div>
                    <?php endif; ?>
                <?php elseif ($field === 'name'): ?>
                    <p class="name"><strong><?php echo $_SESSION[$field]; ?></strong></p>
                <?php elseif ($field === 'college_address'): ?>
                    <p class="college-address"><?php echo $_SESSION[$field]; ?></p>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <img src="<?php echo $_SESSION['signature']; ?>" alt="Signature" class="signature">
    </div>
    <div class="back">
        <img src="data:image/png;base64,<?php echo $qrCodeImageData; ?>" alt="QR Code" class="qr-code">
        <p class="qr-text">Scan the qr code for SmartId</p>
    </div>
</div>
