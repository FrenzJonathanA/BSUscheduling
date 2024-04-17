<!DOCTYPE html>
<html>
<head>
    <title>Verification</title>
</head>
<body>

<h2>Enter Verification Code</h2>

<form action="verify_regCode.php" method="post">
    <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>">
    <label for="verification_code">Verification Code:</label>
    <input type="text" name="verification_code" id="verification_code" required>
    <button type="submit">Verify</button>
</form>

</body>
</html>