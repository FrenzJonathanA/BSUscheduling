

<?php 

    $pageTitle = "Reset Password";
    
    include('header.php'); 

?>


<?php
require_once 'database/con_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $resetCode = $_POST['reset_code'];

    $stmt = $conn->prepare("SELECT email, reset_expiration FROM user WHERE reset_code =?");
    $stmt->bind_param("s", $resetCode);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Check if the reset code has expired
        if (strtotime($user['reset_expiration']) > time()) {
            $error_message = "The reset code has expired. Please request a new one.";
        } else {
            header("Location: reset_password_form.php?email=". urlencode($user['email']));
            exit();
        }
    } else {
        $error_message = "Invalid reset code. Please try again.";
    }
}
?>
<link rel="stylesheet" href="scss/style.css"> 

<div class="reset-pass">
    <div class="container">
        <div class="reset-wrapper">
            <h2>Reset Password</h2>
            <div class="reset-form">
                <?php if(isset($error_message)) echo '<p class="error-message">'. $error_message. '</p>';?>
                <label for="reset_code">Enter RESET code:</label>
                <form method="post" action="verify_reset_code.php"> 
                    <input type="text" id="reset_code" name="reset_code" required>
                    <button type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
    

    <?php 

    include('footer.php'); 

    ?>
</body>
</html>